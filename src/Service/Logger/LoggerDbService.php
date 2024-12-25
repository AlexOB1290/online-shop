<?php

namespace Service\Logger;

use Model\Log;

class LoggerDbService implements LoggerServiceInterface
{
    public function error(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');
        $header = $message;
        $message = $data['message'];
        $line = $data['line'];
        $file = $data['file'];

        Log::create($header, $date, $message, $line, $file);
    }

    public function info(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');
        $header = $message;
        $message = $data['message'];
        $line = $data['line'];
        $file = $data['file'];

        Log::create($header, $date, $message, $line, $file);
    }

    public function warning(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');
        $header = $message;
        $message = $data['message'];
        $line = $data['line'];
        $file = $data['file'];

        Log::create($header, $date, $message, $line, $file);
    }
}