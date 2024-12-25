<?php
require_once './../Core/Autoloader.php';

use Controller\CartController;
use Controller\CatalogController;
use Controller\OrderController;
use Controller\UserController;
use Controller\UserProductController;
use Core\App;
use Core\Autoloader;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Service\Auth\AuthSessionService;
use Service\Logger\LoggerDbService;

$rootPath = str_replace('public', '', __DIR__);

Autoloader::registrate($rootPath);

$loggerService = new LoggerDbService();

$app = new App($loggerService);

$app->addRoute('/registrate', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/registrate', 'POST', UserController::class, 'handleRegistrationForm', RegistrateRequest::class);
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'handleLoginForm', LoginRequest::class);
$app->addRoute('/logout', 'GET', AuthSessionService::class, 'logout');
$app->addRoute('/catalog', 'GET', CatalogController::class, 'getCatalogPage');
//$app->addRoute('/add-product', 'GET', UserProductController::class, 'getAddProductForm');
$app->addRoute('/add-product', 'POST', UserProductController::class, 'handleAddProductForm', AddProductRequest::class);
$app->addRoute('/cart', 'GET', CartController::class, 'getCartPage');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrderForm', OrderRequest::class);
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');

$app->run();