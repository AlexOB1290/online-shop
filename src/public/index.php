<?php
require_once './../Core/Autoloader.php';

use Core\Autoloader;
use Core\App;

$rootPath = str_replace('public', '', __DIR__);

Autoloader::registrate($rootPath);

$app = new App();
$app->run();