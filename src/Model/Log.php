<?php

namespace Model;

class Log extends Model
{
    public static function create(string $header, string $date, string $message, int $line, $file): bool
    {
        $stmt = self::getPdo()->prepare("INSERT INTO logs (header, date, message, line, file) VALUES (:header, :date, :message, :line, :file)");
        return $stmt->execute(['header' => $header, "date" => $date, "message" => $message, "line" => $line, "file" => $file]);
    }
}