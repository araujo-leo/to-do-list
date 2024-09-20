<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/Routes.php';

// Instanciar a classe Routes
$routes = new Routes();

// Registrar rotas
$routes->registerRoutes();

// Capturar a URI da requisição
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover a subpasta do caminho da URI
$baseFolder = '/to-do-list/backend/api';
$requestUri = str_replace($baseFolder, '', $requestUri);

$router->dispatch();
