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

    public static function createObjectAut(array $data): static
    {
        $obj = new static();
        $arrayProp = get_class_vars(static::class);
        foreach ($arrayProp as $property => $value) {
            $propertyLower = strtolower($property);
            foreach ($data as $dataKey => $dataValue) {
                $key = strtolower(str_replace("_", "", $dataKey));
                if ($key === $propertyLower) {
                    $obj->$property = $dataValue;
                    break;
                }
            }
        }
        return $obj;
    }
}