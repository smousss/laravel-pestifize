<?php

namespace Smousss\Laravel\Pestifize\Commands;

use SplFileInfo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class PestifizeCommand extends Command
{
    protected $signature = 'smousss:pestifize {directory?}';

    protected $description = 'Migrate your tests to Pest 2';

    public function handle() : int
    {
        if (empty(config('pestifize.secret_key'))) {
            $this->error('Please generate a secret key on smousss.com and add it to your .env file as SMOUSSS_SECRET_KEY.');

            return self::FAILURE;
        }

        $files = collect(File::allFiles($this->argument('directory') ?? base_path('tests')))->map(function (SplFileInfo $file) {
            if (str($file)->endsWith('Test.php')) {
                return $file->getPathname();
            }
        })->filter()->values()->toArray();

        $this->line("Hello, I'm Smousss, your friendly AI assistant!");

        $choice = $this->choice('Which file should I process?', $files, 0, null, true);

        collect($choice)
            ->each(function (string $test) {
                $code = File::get($test);

                $this->line("GPT-4 is generating tokens for {$test}…");

                try {
                    $response = Http::withToken(config('pestifize.secret_key'))
                        ->timeout(300)
                        ->retry(3, 1000)
                        ->withHeaders(['Accept' => 'application/json'])
                        ->post(config('pestifize.debug', false)
                            ? 'https://smousss.test/api/pestifize'
                            : 'https://smousss.com/api/pestifize', compact('code'))
                        ->throw()
                        ->json();

                    File::put($test, $response['data']);

                    $this->info("Your test has been migrated to Pest 2 and is available at $test! 🎉");
                    $this->info("Tokens: {$response['meta']['consumed_tokens']}");
                } catch (RequestException $e) {
                    $this->error($e->response->json()['message']);

                    exit(self::FAILURE);
                }
            });

        return self::SUCCESS;
    }
}
