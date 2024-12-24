<?php

namespace Service\Logger;

class LoggerFileService implements LoggerServiceInterface
{
    public function error(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');

        $filePath = './../Storage/Log/error.txt';

        $str = "";
        foreach ($data as $key => $value) {
            $str .= "$key: $value\n";
        }

        $strBlock = "\n$message:\n{$str}";

        file_put_contents($filePath, $strBlock, FILE_APPEND);
    }

    public function info(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');

        $filePath = './../Storage/Log/info.txt';

        $str = "";
        foreach ($data as $key => $value) {
            $str .= "$key: $value\n";
        }

        $strBlock = "\n$message:\n{$str}";

        file_put_contents($filePath, $strBlock, FILE_APPEND);
    }

    public function warning(string $message, array $data = []): void
    {
        date_default_timezone_set('Asia/Irkutsk');
        $date = date('d-m-Y H:i:s');

        $filePath = './../Storage/Log/warning.txt';

        $str = "";
        foreach ($data as $key => $value) {
            $str .= "$key: $value\n";
        }

        $strBlock = "\n$message:\n{$str}";

        file_put_contents($filePath, $strBlock, FILE_APPEND);
    }
}