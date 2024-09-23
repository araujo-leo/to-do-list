<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/UserModel.php';

class UserController {
    private $user;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new UserModel($db);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->name) && !empty($data->email)  && !empty($data->password)) {
            $this->user->name = $data->name;
            $this->user->email = $data->email;
            $this->user->password = $data->password; 

            $response = $this->user->create($this->user);

            if (isset($response['status'])) {
                http_response_code($response['status'] === 'success' ? 200 : 400);
                echo json_encode($response);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Erro ao efetuar cadastro."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos!"]);
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password)) {
            $this->user->email = $data->email;
            $this->user->password = $data->password;

            $response = $this->user->login($this->user);

            if (isset($response['status'])) {
                http_response_code($response['status'] === 'success' ? 200 : 400);
                echo json_encode($response);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "Erro ao efetuar login."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos!"]);
        }
    }
}
