<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class UserModel {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, jwt_token) VALUES (?, ?, ?, ?)";

        $token = bin2hex(random_bytes(32));

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("ssss", $data->name, $data->email, $data->password, $token);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return true; 
                }
            }
            $stmt->close(); 
        }else{
            return false; 
        }
    }


    

}
