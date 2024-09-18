<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/UserModel.php';

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register() {
        json_encode('dsadada');
        $user = new UserModel($this->db); 
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'POST': 
                $data = json_decode(file_get_contents("php://input"));
                if (!empty($data->name)) {
                    $user->name = $data->name;

                    if ($user->create()) {
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
                break;

            default:
                http_response_code(405);
                echo json_encode(array("message" => "Método não permitido."));
                break;
        }
    }

    public function login() {
    }
}
