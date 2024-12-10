<?php
namespace Core;

class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getRegistrationForm',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'handleRegistrationForm',
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => 'Controller\UserController',
                'method' => 'handleLoginForm',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'Controller\CatalogController',
                'method' => 'getCatalogPage',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'Controller\UserProductController',
                'method' => 'getAddProductForm',
            ],
            'POST' => [
                'class' => 'Controller\UserProductController',
                'method' => 'handleAddProductForm',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'Controller\CartController',
                'method' => 'getCartPage',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => 'Controller\UserController',
                'method' => 'logout',
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => 'Controller\OrderController',
                'method' => 'getOrderPage',
            ],
            'POST' => [
                'class' => 'Controller\OrderController',
                'method' => 'handleOrderForm',
            ]
        ],
        '/orders' => [
            'GET' => [
                'class' => 'Controller\OrderController',
                'method' => 'getOrders',
            ],
        ],
    ];
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes)) {
            $methods = $this->routes[$uri];
            if (array_key_exists($method, $methods)) {
                $handler = $methods[$method];

                $class  = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();
                $obj->$method();
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } else {
            require_once './../View/404.html';
        }
    }
}
