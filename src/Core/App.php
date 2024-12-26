<?php
namespace Core;

use ReflectionException;
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
    private array $objects;

    public function __construct(LoggerServiceInterface $loggerService)
    {
        $this->loggerService = $loggerService;
        $this->objects = [
            OrderService::class => new OrderService(),
            CartService::class =>new CartService(),
            AuthServiceInterface::class => new AuthSessionService(),
        ];
    }

    /**
     * @throws ReflectionException
     */
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

                if ($this->prepareObj($class)){
                    $obj = new $class(...$this->prepareObj($class));
                } else {
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

    /**
     * @throws ReflectionException
     */
    private function prepareObj(string $className): ?array
    {
        $reflector = new \ReflectionClass($className);
        $constructReflector = $reflector->getConstructor();
        if(!$constructReflector) {
            return null;
        }
        $constructArguments = $constructReflector->getParameters();
        $args = [];
        foreach ($constructArguments as $argument) {
            $argumentType = $argument->getType()->getName();
            $args[$argument->getName()] = $this->getObj($argumentType);
        }

        return $args;
    }

    private function getObj(string $className): mixed
    {
        return $this->objects[$className];
    }


}