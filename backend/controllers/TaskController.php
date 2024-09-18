<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/TaskModel.php';

class TaskController
{
    public function index()
    {
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
            case 'POST':
                $data = json_decode(file_get_contents("php://input"));

                if (!empty($data->name)) {
                    $task->name = $data->name;

                    if ($task->create()) {
                        http_response_code(201);
                        echo json_encode(array("message" => "Tarefa criada!"));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("message" => "Não foi possível criar a tarefa!"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "Dados incompletos!"));
                }
                break;

            case 'PUT':
                $data = json_decode(file_get_contents("php://input"));
                if (!empty($data->id) && !empty($data->status)) {
                    $task->id = $data->id;
                    $task->status = $data->status;

                    if ($task->updateStatus()) {
                        http_response_code(200);
                        echo json_encode(array("message" => "Status da tarefa atualizados!"));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("message" => "Não foi possível atualizar sua tarefa!"));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("message" => "Dados incompletos!"));
                }
                break;

            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"));
                if (!empty($data->id)) {
                    $task->id = $data->id;
                    if ($task->deleteTask()) {
                        http_response_code(200);
                        echo json_encode(array("message" => "Tarefa deletada com sucesso!"));
                    } else {
                        http_response_code(400);
                        echo json_encode(array("message" => "Não foi possível deletar a tarefa, por favor tente novamente."));
                    }
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(array("message" => "Método não permitido."));
                break;

        }
    }
}
