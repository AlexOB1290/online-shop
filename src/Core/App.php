<?php
namespace Core;

use Request\AddProductRequest;
use Request\OrderRequest;
use Request\Request;
use Request\RegistrateRequest;
use Request\LoginRequest;

class App
{
    private array $routes = [];
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

                $obj = new $class();

                if(str_contains($classMethod, 'handleRegistrat')) {
                    $request = new RegistrateRequest($uri, $method, $_POST);
                } elseif (str_contains($classMethod, 'handleLogin')) {
                    $request = new LoginRequest($uri, $method, $_POST);
                } elseif (str_contains($classMethod, 'handleAddProduct')) {
                    $request = new AddProductRequest($uri, $method, $_POST);
                } elseif (str_contains($classMethod, 'handleOrder')) {
                    $request = new OrderRequest($uri, $method, $_POST);
                } else {
                    $request = null;
                }

                $obj->$classMethod($request);
            } else {
                echo "$method не поддерживается адресом $uri";
            }
        } else {
            //http_response_code(404);
            require_once './../View/404.html';
        }
    }

    public function addRoute(string $uriName, string $uriMethod, string $className, string $method): void
    {
        if(!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
        } else {
            echo "$uriMethod уже зарегистрирован для $uriName" . "<br>";
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}