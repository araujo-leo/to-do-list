<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/TaskModel.php';

class TaskController
{
    private $task;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->task = new TaskModel($db);
    }

    public function list() {
        $tasks = $this->task->list();
        if ($tasks !== false) {
            http_response_code(200);
            echo json_encode(array("message" => "Tarefas obtidas!", "data" => $tasks));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível obter as tarefas."));
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->name)) {
            $this->task->name = $data->name;

            if ($this->task->create()) {
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
    }

    public function update() {
        $data = json_decode(file_get_contents("php://input"));

    
        
        if (!empty($data->id) && (!empty($data->status) || !empty($data->name))) {

            $this->task->id = $data->id;
            
            if (isset($data->name)) {
                $this->task->name = $data->name;
            }
            
            if (isset($data->status)) {
                $this->task->status = $data->status;
            }

            if ($this->task->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Tarefa atualizada!"));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível atualizar sua tarefa!"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos!"));
        }
    }

    public function delete() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id)) {
            $this->task->id = $data->id;
            if ($this->task->deleteTask()) {
                http_response_code(200);
                echo json_encode(array("message" => "Tarefa deletada com sucesso!"));
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Não foi possível deletar a tarefa, por favor tente novamente."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos!"));
        }
    }
}
