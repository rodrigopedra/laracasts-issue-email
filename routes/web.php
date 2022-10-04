<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $logpath = storage_path('logs/laravel-' . date('Y-m-d') . '.log');

    return view('home', ['log' => readLastLines($logpath, 18)]);
});

Route::post('/', function () {
    Mail::send('mail.sample', [], function ($message) {
        $message->subject('sample mail')
            // change to real emails if testing with a real SMTP
            ->to('joseph@example.com')
            ->to('mary@example.com');
    });

    return redirect()->to('/');
});

// @see https://stackoverflow.com/a/40288501
function readLastLines(string $filepath, int $count): bool|string
{
    if (! is_file($filepath)) {
        return false;
    }

    $bufferSize = match (true) {
        $count < 2 => 64,
        $count < 10 => 512,
        default => 4096,
    };

    $file = fopen($filepath, 'r');
    fseek($file, 0, SEEK_END);

    $lineCount = 0;
    $output = '';

    while (ftell($file) > 0 && $lineCount < $count) {
        $chunkSize = min(ftell($file), $bufferSize);

        fseek($file, -$chunkSize, SEEK_CUR);

        $chunk = fread($file, $chunkSize);
        $output = $chunk . $output;

        fseek($file, -$chunkSize, SEEK_CUR);

        $lineCount += min(
            substr_count($chunk, "\r\n"),
            substr_count($chunk, "\r"),
            substr_count($chunk, "\n"),
        );
    }

    $lines = preg_split('/\r\n|\r|\n/', $output);

    while (count($lines) > $count) {
        array_shift($lines);
    }

    return implode(PHP_EOL, $lines);
}
