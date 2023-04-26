<?php

use function Pest\Laravel\artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake([
        'smousss.com/api/pestifize' => Http::response([
            'data' => 'foo',
            'meta' => ['consumed_tokens' => 1234],
        ]),
    ]);

    config(['pestifize.secret_key' => 'foo']);

    File::put(__DIR__ . '/output/FirstExampleTest.php', 'foo');
    File::put(__DIR__ . '/output/SecondExampleTest.php', 'foo');
});

it('lets user choose files', function () {
    artisan('smousss:pestifize', ['directory' => __DIR__ . '/output'])
        ->expectsOutput("Hello, I'm Smousss, your friendly AI assistant!")
        ->expectsChoice('Which file should I process?', $test = __DIR__ . '/output/FirstExampleTest.php', [
            __DIR__ . '/output/FirstExampleTest.php',
            __DIR__ . '/output/SecondExampleTest.php',
        ])
        ->expectsOutput("GPT-4 is generating tokens for {$test}…")
        ->expectsOutput("Your test has been migrated to Pest 2 and is available at $test! 🎉")
        ->expectsOutput('Tokens: 1234')
        ->assertExitCode(0);
});

it("throws an exception when the secret key isn't set", function () {
    config(['pestifize.secret_key' => null]);

    artisan('smousss:pestifize', ['directory' => __DIR__ . '/output'])
        ->expectsOutput('Please generate a secret key on smousss.com and add it to your .env file as SMOUSSS_SECRET_KEY.')
        ->assertExitCode(1);
});
