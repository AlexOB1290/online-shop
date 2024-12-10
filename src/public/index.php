<?php
require_once './../Core/Autoloader.php';
use Core\Autoloader;
use Core\App;

$autoloader = new Autoloader();
$autoloader->autoload();

$app = new App();
$app->run();