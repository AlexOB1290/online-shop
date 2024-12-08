<?php

use Core\App;

//$autoloadCore = function (string $classname) {
//    $path = "./../Core/$classname.php";
//
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//
//    return false;
//};
//
//$autoloadController = function (string $classname) {
//    $path = "./../Controller/$classname.php";
//
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//
//    return false;
//};
//
//$autoloadModel = function (string $classname) {
//    $path = "./../Model/$classname.php";
//
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//
//    return false;
//};
//
//spl_autoload_register($autoloadCore);
//spl_autoload_register($autoloadController);
//spl_autoload_register($autoloadModel);

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


$app = new App();
$app->run();