<?php
require_once './UserController.php';
require_once './UserProductController.php';
require_once './CatalogController.php';
require_once './CartController.php';
class App {
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri === '/registrate') {
            $registration = new UserController();
            if ($method === 'GET') {
                $registration->getRegistrationForm();
            } elseif ($method === 'POST') {
                $registration->handleRegistrationForm();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } elseif ($uri === '/login') {
            $login = new UserController();
            if ($method === 'GET') {
                $login->getLoginForm();
            } elseif ($method === 'POST') {
                $login->handleLoginForm();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } elseif ($uri === '/catalog') {
            $catalog = new CatalogController();
            if ($method === 'GET') {
                $catalog->getCatalogPage();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } elseif ($uri === '/add-product') {
            $userProduct = new UserProductController();
            if ($method === 'GET') {
                $userProduct->getAddProductForm();
            } elseif ($method === 'POST') {
                $userProduct->addUserProduct();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } elseif ($uri === '/cart') {
            $cart = new CartController();
            if ($method === 'GET') {
                $cart->getCartPage();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } elseif ($uri === '/logout') {
            $logout = new UserController();
            if ($method === 'GET') {
                $logout->logout();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } else {
            require_once './404.html';
        }
    }
}
