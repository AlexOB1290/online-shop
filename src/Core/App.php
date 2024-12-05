<?php
require_once './../Controller/UserController.php';
require_once './../Controller/UserProductController.php';
require_once './../Controller/CatalogController.php';
require_once './../Controller/CartController.php';
require_once './../Controller/OrderController.php';
class App {
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrationForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'handleRegistrationForm',
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'handleLoginForm',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'CatalogController',
                'method' => 'getCatalogPage',
            ],
        ],
        '/add-product' => [
            'GET' => [
                'class' => 'UserProductController',
                'method' => 'getAddProductForm',
            ],
            'POST' => [
                'class' => 'UserProductController',
                'method' => 'handleAddProductForm',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCartPage',
            ],
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout',
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'getOrderForm',
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'handleOrderForm',
            ]
        ],
        '/user-order' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'getUserOrderPage',
            ],
        ],
    ];
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes)) {
            if (array_key_exists($method, $this->routes[$uri])) {
                    foreach ($this->routes[$uri][$method] as $key => $methodRoute) {
                        if($key === 'class'){
                            $obj = new $methodRoute();
                        } elseif ($key === 'method'){
                            $obj->$methodRoute();
                        }
                    }
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } else {
            require_once './../View/404.html';
        }


//        if ($uri === '/registrate') {
//            if ($method === 'GET') {
//                require_once './get_registration.php';
//            } elseif ($method === 'POST') {
//                require_once './handle_registration.php';
//            } else {
//                echo "$method не поддерживается адресом $uri";
//            }

//        switch ($uri) {
//            case '/registrate':
//                $registration = new UserController();
//                if ($method === 'GET') {
//                    $registration->getRegistrationForm();
//                } elseif ($method === 'POST') {
//                    $registration->handleRegistrationForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/login':
//                $login = new UserController();
//                if ($method === 'GET') {
//                    $login->getLoginForm();
//                } elseif ($method === 'POST') {
//                    $login->handleLoginForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/catalog':
//                $catalog = new CatalogController();
//                if ($method === 'GET') {
//                    $catalog->getCatalogPage();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/add-product':
//                $userProduct = new UserProductController();
//                if ($method === 'GET') {
//                    $userProduct->getAddProductForm();
//                } elseif ($method === 'POST') {
//                    $userProduct->handleAddProductForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/cart':
//                $cart = new CartController();
//                if ($method === 'GET') {
//                    $cart->getCartPage();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/logout':
//                $logout = new UserController();
//                if ($method === 'GET') {
//                    $logout->logout();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/order':
//                $order = new OrderController();
//                if ($method === 'GET') {
//                    $order->getOderForm();
//                } elseif ($method === 'POST') {
//                    $order->handleOrderForm();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            case '/user-order':
//                $order = new OrderController();
//                if ($method === 'GET') {
//                    $order->getUserOrderPage();
//                } else {
//                    echo "$method не поддерживается адресом $uri";
//                }
//                break;
//            default:
//                require_once './../View/404.html';
//                break;
//        }
    }
}
