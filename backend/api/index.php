<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/Routes.php';

class Router {
    private $routes = [];

    public function get($route, $callback) {
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback) {
        $this->addRoute('POST', $route, $callback);
    }

    private function addRoute($method, $route, $callback) {
        $this->routes[] = compact('method', 'route', 'callback');
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
    
        $basePath = '/to-do-list/backend/api';
        $requestUri = str_replace($basePath, '', $requestUri);
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['route'] === $requestUri) {
                call_user_func($route['callback']);
                return;
            }
        }
    
        http_response_code(404);
        echo json_encode(["message" => "Rota não encontrada"]);
    }
}

$router = new Router();
Routes::init($router);

$router->dispatch();