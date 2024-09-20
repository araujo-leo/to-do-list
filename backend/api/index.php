<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/Routes.php';

$routes = new Routes();

$routes->registerRoutes();

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$baseFolder = '/to-do-list/backend/api';
$requestUri = str_replace($baseFolder, '', $requestUri);

// Tratar a requisição
$routes->handleRequest($requestUri);
