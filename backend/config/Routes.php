<?php

class Routes {
    private $routes = [];

    public function addRoute($path, $controller, $method) {
        $this->routes[$path] = [$controller, $method];
    }

    public function handleRequest($requestUri) {
        // Depuração: Verifique o valor da URI da requisição
        error_log("Request URI: " . $requestUri);

        if (isset($this->routes[$requestUri])) {
            list($controller, $method) = $this->routes[$requestUri];

            // Depuração: Verifique se a classe do controlador existe
            if (class_exists($controller)) {
                $controllerInstance = new $controller($this->getDatabaseConnection());

                // Depuração: Verifique se o método existe
                if (method_exists($controllerInstance, $method)) {
                    call_user_func([$controllerInstance, $method]);
                } else {
                    echo json_encode(["message" => "Método não encontrado."], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(["message" => "Controlador não encontrado."], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(["message" => "404 - Rota não encontrada."], JSON_UNESCAPED_UNICODE);
        }
    }

    public function registerRoutes() {
        $this->addRoute('/register', 'UserController', 'register');
        $this->addRoute('/login', 'UserController', 'login');
        $this->addRoute('/task', 'TaskController', 'index');
    }

    private function getDatabaseConnection() {
        require_once '../config/Database.php';
        $database = new Database();
        return $database->getConnection();
    }
}
