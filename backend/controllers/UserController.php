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
            $this->user->password = password_hash($data->password, PASSWORD_DEFAULT); 

            if ($this->user->create($this->user)) {
                http_response_code(201); 
                echo json_encode(array("message" => "Usuário criado com sucesso!"));
            } else {
                http_response_code(503); 
                echo json_encode(array("message" => "Não foi possível criar o usuário!"));
            }
        } else {
            http_response_code(400); 
            echo json_encode(array("message" => "Dados incompletos!"));
        }
    }

    public function login() {
        // Lógica para login
    }
}
