<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $logpath = storage_path('logs/laravel-' . date('Y-m-d') . '.log');

    return view('home', ['log' => readLastLines($logpath, 17)]);
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

function readLastLines(string $filepath, int $lines): string
{
    if (! is_file($filepath)) {
        return '';
    }

    $cursor = -1;

    $file = fopen($filepath, 'r');
    fseek($file, $cursor, SEEK_END);
    $char = fgetc($file);

    while (in_array($char, ["\r", "\n"], true)) {
        fseek($file, $cursor--, SEEK_END);
        $char = fgetc($file);
    }

    $content = '';
    $count = 0;

    while ($char !== false) {
        $content = $char . $content;

        fseek($file, $cursor--, SEEK_END);
        $char = fgetc($file);

        $isNewLine = false;

        while (in_array($char, ["\r", "\n"], true)) {
            if ($isNewLine === false) {
                $isNewLine = true;
                $count++;
            }

            $content = PHP_EOL . $content;

            fseek($file, $cursor--, SEEK_END);
            $char = fgetc($file);
        }

        if ($count >= $lines) {
            break;
        }
    }

    fclose($file);

    return $content;
}
