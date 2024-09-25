<?php

require '../vendor/autoload.php';

class UserModel
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data)
    {
        // Verifica se o e-mail já existe
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("s", $data->email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return array("status" => "error", "message" => "E-mail já está em uso.");
            }
            $stmt->close();
        }

        $query = "INSERT INTO " . $this->table_name . " (name, email, password) VALUES (?, ?, ?)";
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("sss", $data->name, $data->email, password_hash($data->password, PASSWORD_DEFAULT));
            if ($stmt->execute()) {
                $stmt->close();
                return array("status" => "success", "message" => "Usuário criado com sucesso.");
            }
            $stmt->close();
        }

        return array("status" => "error", "message" => "Erro ao criar o usuário.");
    }

    public function login($data)
    {
        $sql = "SELECT id, name, email, password FROM " . $this->table_name . " WHERE email = ? LIMIT 1";

        if ($stmt = $this->conn->prepare($sql)) {
            $stmt->bind_param("s", $data->email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();

                if (password_verify($data->password, $usuario['password'])) {
                    $tokenCheckQuery = "SELECT token FROM token WHERE user_id = ?";
                    if ($tokenStmt = $this->conn->prepare($tokenCheckQuery)) {
                        $tokenStmt->bind_param("i", $usuario['id']);
                        $tokenStmt->execute();
                        $tokenResult = $tokenStmt->get_result();
                        $tokenStmt->close();

                        if ($tokenResult->num_rows == 0) {
                            $token = bin2hex(random_bytes(32));
                            if ($this->storeToken($usuario['id'], $token)) {
                                return array(
                                    "status" => "success",
                                    "message" => "Login realizado com sucesso.",
                                    "token" => $token,
                                );
                            } else {
                                return array("status" => "error", "message" => "Erro ao armazenar o token.");
                            }
                        } else {
                            if ($tokenResult->num_rows > 0) {
                                $existingToken = $tokenResult->fetch_assoc()['token'];
                                return array(
                                    "status" => "success",
                                    "message" => "Token já existe.",
                                    "token" => $existingToken,
                                );
                            }
                        }
                    } else {
                        return array("status" => "error", "message" => "Erro ao verificar token.");
                    }
                } else {
                    return array("status" => "error", "message" => "Senha incorreta.");
                }
            } else {
                return array("status" => "error", "message" => "Usuário não encontrado.");
            }
        } else {
            return array("status" => "error", "message" => "Erro ao preparar a consulta.");
        }
    }

    private function storeToken($id, $token)
    {
        $query = "INSERT INTO token (user_id, token) VALUES (?, ?)";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("is", $id, $token);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
            $stmt->close();
        }

        return false;
    }

    public function validateToken($token) {
        $query = "SELECT user_id FROM token WHERE token = ? LIMIT 1";
    
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
    
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return $user['user_id']; 
            }
        }
    
        return false; 
    }
}
