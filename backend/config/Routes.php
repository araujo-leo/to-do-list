<?php

class Routes {
    private $routes = [];

    // Registrar uma rota com um controlador e um método
    public function addRoute($path, $controller, $method) {
        $this->routes[$path] = [$controller, $method];
    }

    // Lidar com a requisição
    public function handleRequest($requestUri) {
        // Adicionar log para depuração
        error_log("Tratando URI: " . $requestUri);

        if (isset($this->routes[$requestUri])) {
            list($controller, $method) = $this->routes[$requestUri];
            
            // Verificar e incluir o arquivo do controlador
            $controllerFile = "../controllers/{$controller}.php";
            if (file_exists($controllerFile)) {
                include_once $controllerFile;
                
                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = new $controller();
                    call_user_func([$controllerInstance, $method]);
                } else {
                    echo json_encode(["message" => "404 - Controlador ou método não encontrado."], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(["message" => "404 - Arquivo de controlador não encontrado."], JSON_UNESCAPED_UNICODE);
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
}
