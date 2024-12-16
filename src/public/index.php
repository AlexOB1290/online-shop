<?php
require_once './../Core/Autoloader.php';

use Core\Autoloader;
use Core\App;
use Controller\UserController;
use Controller\CatalogController;
use Controller\UserProductController;
use Controller\CartController;
use Controller\OrderController;

$rootPath = str_replace('public', '', __DIR__);

Autoloader::registrate($rootPath);

$app = new App();

$app->addRoute('/registrate', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/registrate', 'POST', UserController::class, 'handleRegistrationForm');
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'handleLoginForm');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/catalog', 'GET', CatalogController::class, 'getCatalogPage');
$app->addRoute('/add-product', 'GET', UserProductController::class, 'getAddProductForm');
$app->addRoute('/add-product', 'POST', UserProductController::class, 'handleAddProductForm');
$app->addRoute('/cart', 'GET', CartController::class, 'getCartPage');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrderForm');
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');

$app->run();