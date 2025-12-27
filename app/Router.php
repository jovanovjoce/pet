<?php
namespace App;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        // дефинирај рути
        $this->routes['GET']['/pet/public/animals'] = 'App\\Controllers\\AnimalsController@index';
        $this->routes['GET']['/pet/public/animals/show'] = 'App\\Controllers\\AnimalsController@show';
        $this->routes['POST']['/pet/public/animals'] = 'App\\Controllers\\AnimalsController@store';
    }

    public function dispatch(string $uri, string $method)
    {
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            [$class, $action] = explode('@', $this->routes[$method][$path]);
            $controller = new $class();
            return $controller->$action();
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}
