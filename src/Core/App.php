<?php
namespace Core;

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
                $method = $handler['method'];

                $obj = new $class();
                $obj->$method();
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