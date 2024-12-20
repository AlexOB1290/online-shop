<?php
require_once './../Core/Autoloader.php';

use Core\Autoloader;
use Core\App;
use Controller\UserController;
use Controller\CatalogController;
use Controller\UserProductController;
use Controller\CartController;
use Controller\OrderController;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\AddProductRequest;
use Service\AuthService;

$rootPath = str_replace('public', '', __DIR__);

Autoloader::registrate($rootPath);

$app = new App();

$app->addRoute('/registrate', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/registrate', 'POST', UserController::class, 'handleRegistrationForm', RegistrateRequest::class);
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'handleLoginForm', LoginRequest::class);
$app->addRoute('/logout', 'GET', AuthService::class, 'logout');
$app->addRoute('/catalog', 'GET', CatalogController::class, 'getCatalogPage');
//$app->addRoute('/add-product', 'GET', UserProductController::class, 'getAddProductForm');
$app->addRoute('/add-product', 'POST', UserProductController::class, 'handleAddProductForm', AddProductRequest::class);
$app->addRoute('/cart', 'GET', CartController::class, 'getCartPage');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrderForm', OrderRequest::class);
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');

$app->run();