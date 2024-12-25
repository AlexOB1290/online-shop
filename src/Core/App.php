<?php
namespace Core;

use ReflectionMethod;
use Request\Request;
use Service\Auth\AuthServiceInterface;
use Service\Auth\AuthSessionService;
use Service\CartService;
use Service\Logger\LoggerFileService;
use Service\Logger\LoggerServiceInterface;
use Service\OrderService;
use ReflectionClass;

class App
{
    private array $routes = [];
    private LoggerServiceInterface $loggerService;
    private OrderService $orderService;
    private CartService $cartService;
    private AuthServiceInterface $authService;

    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->authService = new AuthSessionService();
    }
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (array_key_exists($uri, $this->routes)) {
            $method = $_SERVER['REQUEST_METHOD'];
            $methods = $this->routes[$uri];
            if (array_key_exists($method, $methods)) {
                $handler = $methods[$method];
                $class  = $handler['class'];
                $classMethod = $handler['method'];
                $requestClass = $handler['requestClass'];

                if(str_contains($class, 'UserController')) {
                    $arrayObject = ['authService'=>$this->authService];
                    $obj = new $class(...$arrayObject);
                } elseif (str_contains($class, 'UserProductController') || str_contains($class, 'CartController') || str_contains($class, 'CatalogController')) {
                    $arrayObject = ['authService'=>$this->authService, 'cartService'=>$this->cartService];
                    $obj = new $class(...$arrayObject);
                } elseif (str_contains($class, 'OrderController')) {
                    $arrayObject = ['authService'=>$this->authService, 'cartService'=>$this->cartService, 'orderService'=>$this->orderService];
                    $obj = new $class(...$arrayObject);
                } else{
                    $obj = new $class();
                }

                if (!empty($requestClass)) {
                    $request = new $requestClass($uri, $method, $_POST);
                } else {
                    $request = new Request($uri, $method, $_POST);
                }

                try {
                    $obj->$classMethod($request);
                } catch (\Throwable $exception) {
                    $this->loggerService->error('Произошла ошибка при обработке', [
                        'message' => $exception->getMessage(),
                        'line' => $exception->getLine(),
                        'file' => $exception->getFile(),
                    ]);

                    http_response_code(500);
                    require_once './../View/500.html';
                }
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } else {
            http_response_code(404);
            require_once './../View/404.html';
        }
    }

    public function addRoute(string $requestUri, string $requestMethod, string $className, string $method, string $requestClass = null): void
    {
        if(!isset($this->routes[$requestUri][$requestMethod])) {
            $this->routes[$requestUri][$requestMethod]['class'] = $className;
            $this->routes[$requestUri][$requestMethod]['method'] = $method;
            $this->routes[$requestUri][$requestMethod]['requestClass'] = $requestClass;
        } else {
            echo "$requestMethod уже зарегистрирован для $requestUri" . "<br>";
        }
    }

}