<?php
namespace Core;

class Autoloader
{
    public static function registrate(string $rootPath): void
    {
        $autoload = function($classname) use ($rootPath) {
            $handlePath = str_replace('\\', '/', $classname);
            $path = "{$rootPath}{$handlePath}.php";

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoload);
    }
}