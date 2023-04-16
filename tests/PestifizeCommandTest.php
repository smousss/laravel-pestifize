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

it('processes every file', function () {
    $first = __DIR__ . '/output/FirstExampleTest.php';
    $second = __DIR__ . '/output/SecondExampleTest.php';

    artisan('smousss:pestifize', ['directory' => __DIR__ . '/output'])
        ->expectsChoice('Should Pestifize process a particular file or everything?', 'Process everything!', [
            'Choose files',
            'Process everything!',
        ])
        ->expectsOutput("GPT-4 is generating tokens for {$first}…")
        ->expectsOutput("Your test has been migrated to Pest 2 and is available at $first! 🎉 (Tokens: 1234)")
        ->expectsOutput("GPT-4 is generating tokens for {$second}…")
        ->expectsOutput("Your test has been migrated to Pest 2 and is available at $second! 🎉 (Tokens: 1234)")
        ->assertExitCode(0);
});

it('lets user choose files', function () {
    artisan('smousss:pestifize', ['directory' => __DIR__ . '/output'])
        ->expectsChoice('Should Pestifize process a particular file or everything?', 'Choose files', [
            'Choose files',
            'Process everything!',
        ])
        ->expectsChoice('Which file should Pestifize process?', $test = __DIR__ . '/output/FirstExampleTest.php', [
            __DIR__ . '/output/FirstExampleTest.php',
            __DIR__ . '/output/SecondExampleTest.php',
        ])
        ->expectsOutput("GPT-4 is generating tokens for {$test}…")
        ->expectsOutput("Your test has been migrated to Pest 2 and is available at $test! 🎉 (Tokens: 1234)")
        ->assertExitCode(0);
});

it("throws an exception when the secret key isn't set", function () {
    config(['pestifize.secret_key' => null]);

    artisan('smousss:pestifize', ['directory' => __DIR__ . '/output'])
        ->expectsOutput('Please generate a secret key on smousss.com and add it to your .env file as SMOUSSS_SECRET_KEY.')
        ->assertExitCode(1);
});
