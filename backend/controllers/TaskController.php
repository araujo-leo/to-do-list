<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/TaskModel.php';

$database = new Database();
$db = $database->getConnection();

$task = new TaskModel($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $tasks = $task->list();

        if ($tasks !== false) {
            http_response_code(200);
            echo json_encode(array("message" => "Tarefas obtidas!", "data" => $tasks));
        } else {
            http_response_code(500); 
            echo json_encode(array("message" => "Não foi possível obter as tarefas."));
        }
        break;
        
    default:
    http_response_code(405);
    echo json_encode(array("message" => "Método não permitido."));
    break;
}
?>