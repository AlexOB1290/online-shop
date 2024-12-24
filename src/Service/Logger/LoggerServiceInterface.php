<?php

namespace Service\Logger;

interface LoggerServiceInterface
{
    public function error(string $message, array $data = []);
    public function info(string $message, array $data = []);
    public function warning(string $message, array $data = []);
}