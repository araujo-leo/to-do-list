<?php
include_once '../config/Database.php';
include_once '../models/TaskModel.php';
include_once '../models/UserModel.php';

class TaskController
{
    private $task;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->task = new TaskModel($db);
        $this->user = new UserModel($db);
    }

    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);

            $userId = $this->user->validateToken($token);
            if ($userId) {
                return $userId;
            }
        }

        http_response_code(401);
        echo json_encode(["message" => "Acesso negado. Token inválido ou ausente."]);
        exit();
    }

    public function list()
    {
        $tasks = $this->task->list();
        if ($tasks !== false) {
            http_response_code(200);
            echo json_encode(array("message" => "Tarefas obtidas!", "data" => $tasks));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Não foi possível obter as tarefas."));
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->task->user_id = $this->authenticate();

        $this->task->name = $data->name;

        $response = $this->task->create($this->user);

        if (isset($response['status'])) {
            http_response_code($response['status'] === 'success' ? 200 : 400);
            echo json_encode($response);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Erro ao atualizar task"]);
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->task->user_id = $this->authenticate();

        if (!empty($data->id) && (!empty($data->status) || !empty($data->name))) {

            $this->task->id = $data->id;

            if (isset($data->name)) {
                $this->task->name = $data->name;
            }

            if (isset($data->status)) {
                $this->task->status = $data->status;
            }

            $response = $this->task->update($this->user);

            if (isset($response['status'])) {
                http_response_code($response['status'] === 'success' ? 200 : 400);
                echo json_encode($response);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Erro ao atualizar task"]);
            }

        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos!"));
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));

        $this->task->user_id = $this->authenticate();
        
        $this->task->id = $data->id;

        $response = $this->task->deleteTask();

        if (isset($response['status'])) {
            http_response_code($response['status'] === 'success' ? 200 : 400);
            echo json_encode($response);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Erro ao deletar tarefa!"]);
        }
    }
}
