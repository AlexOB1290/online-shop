<?php

namespace Service\Logger;

class LoggerService
{
    public function writeLog(\Throwable $exception): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $filePath = './../Storage/Log/error.txt';
        $strError = "\n\nLog information: \nDate: {$date} \nMessage: {$message} \nFile: {$file} \nLine: {$line}";

        file_put_contents($filePath, $strError, FILE_APPEND);
    }
}