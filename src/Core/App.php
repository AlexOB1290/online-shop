<?php
require_once './../Controller/UserController.php';
require_once './../Controller/UserProductController.php';
require_once './../Controller/CatalogController.php';
require_once './../Controller/CartController.php';
require_once './../Controller/OrderController.php';
class App {
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($uri) {
            case '/registrate':
                $registration = new UserController();
                if ($method === 'GET') {
                    $registration->getRegistrationForm();
                } elseif ($method === 'POST') {
                    $registration->handleRegistrationForm();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/login':
                $login = new UserController();
                if ($method === 'GET') {
                    $login->getLoginForm();
                } elseif ($method === 'POST') {
                    $login->handleLoginForm();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/catalog':
                $catalog = new CatalogController();
                if ($method === 'GET') {
                    $catalog->getCatalogPage();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/add-product':
                $userProduct = new UserProductController();
                if ($method === 'GET') {
                    $userProduct->getAddProductForm();
                } elseif ($method === 'POST') {
                    $userProduct->handleAddUserProductForm();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/cart':
                $cart = new CartController();
                if ($method === 'GET') {
                    $cart->getCartPage();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/logout':
                $logout = new UserController();
                if ($method === 'GET') {
                    $logout->logout();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            case '/order':
                $order = new OrderController();
                if ($method === 'GET') {
                    $order->getOderForm();
                } elseif ($method === 'POST') {
                    $order->handleOrderForm();
                } else {
                    echo "$method не поддерживается адресом $uri";
                }
                break;
            default:
                require_once './../View/404.html';
                break;
        }
    }
}
