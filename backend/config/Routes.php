<?php

class Routes {
    private $routes = [];

    public function addRoute($path, $callback) {
        $this->routes[$path] = $callback;
    }

    public function handleRequest($requestUri) {
        if (isset($this->routes[$requestUri])) {
            $callback = $this->routes[$requestUri]; // Obtém a função associada à rota
            $callback(); // Executa a função
        } else {
            echo json_encode(["message" => "404 - Rota não encontrada."], JSON_UNESCAPED_UNICODE);
        }
    }

    public function registerRoutes() {
        $this->addRoute('/login', function() {
            echo json_encode(["message" => "Rota de Login chamada."]);
            include_once '../controllers/UserController.php';
        });

        $this->addRoute('/task', function() {
            include_once '../controllers/TaskController.php';
        });
    }
}
