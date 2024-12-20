<?php
namespace Model;

use PDO;

class Model
{
    protected static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        }

        return self::$pdo;
    }
}