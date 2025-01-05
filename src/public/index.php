<?php
require_once './../Core/Autoloader.php';

use Controller\CartController;
use Controller\CatalogController;
use Controller\OrderController;
use Controller\UserController;
use Controller\UserProductController;
use Controller\ReviewController;
use Core\App;
use Core\Autoloader;
use Core\Container;
use Request\AddProductRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\ReviewRequest;
use Request\CatalogRequest;
use Service\Auth\AuthSessionService;
use Service\Logger\LoggerDbService;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;
use Service\ReviewService;

$rootPath = str_replace('public', '', __DIR__);

Autoloader::registrate($rootPath);

$container = new Container();

$container->set(LoggerServiceInterface::class, function () {
    return new LoggerDbService();
});

$container->set(AuthServiceInterface::class, function () {
    return new AuthSessionService();
});

$container->set(UserController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);

    return new UserController($authService);
});

$container->set(CartController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $cartService = new CartService();

    return new CartController($authService, $cartService);
});

$container->set(OrderController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $orderService = new OrderService();
    $cartService = new CartService();

    return new OrderController($authService, $cartService, $orderService);
});

$container->set(UserProductController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $cartService = new CartService();

    return new UserProductController($authService, $cartService);
});

$container->set(CatalogController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $cartService = new CartService();

    return new CatalogController($authService, $cartService);
});

$container->set(ReviewController::class, function (Container $container) {
    $authService = $container->get(AuthServiceInterface::class);
    $cartService = new CartService();
    $reviewService = new ReviewService();

    return new ReviewController($authService, $cartService, $reviewService);
});

$app = new App($container);

$app->addRoute('/registrate', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/registrate', 'POST', UserController::class, 'handleRegistrationForm', RegistrateRequest::class);
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'handleLoginForm', LoginRequest::class);
$app->addRoute('/logout', 'GET', AuthServiceInterface::class, 'logout');
$app->addRoute('/catalog', 'GET', CatalogController::class, 'getCatalogPage');
$app->addRoute('/add-product', 'POST', UserProductController::class, 'handleAddProductForm', AddProductRequest::class);
$app->addRoute('/cart', 'GET', CartController::class, 'getCartPage');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrderForm', OrderRequest::class);
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');
$app->addRoute('/product-card', 'POST', CatalogController::class, 'getProductCard', CatalogRequest::class);
$app->addRoute('/review', 'POST', ReviewController::class, 'getReviewForm', ReviewRequest::class);
$app->addRoute('/add-review', 'POST', ReviewController::class, 'handleReviewForm', ReviewRequest::class);

$app->run();