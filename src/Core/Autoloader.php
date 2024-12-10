<?php
namespace Core;

class Autoloader
{
    public function autoload(): void
    {
        $autoload = function($classname) {
            $handlerPath = str_replace('\\', '/', $classname);
            $path = "./../$handlerPath.php";

            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoload);
    }
}