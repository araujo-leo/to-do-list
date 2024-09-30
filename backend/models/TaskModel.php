<?php
class TaskModel
{
    private $conn;
    private $table_name = "todos";

    public $id;
    public $name;
    public $status;
    public $user_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function list()
    {
        var_dump($this->status);

        if (isset($this->status) && !empty($this->status) && !empty($this->user_id) && isset($this->user_id)) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE status = ? AND user_id = ?";
        } else {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ?";
        }

        if ($stmt = $this->conn->prepare($query)) {
            if (isset($this->status) && !empty($this->status)) {
                $stmt->bind_param("si", $this->status, $this->user_id);
            } else if (!empty($this->user_id) && isset($this->user_id)) {
                $stmt->bind_param("i", $this->user_id);
            }

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $tasks = $result->fetch_all(MYSQLI_ASSOC);
                    $stmt->close();

                    return array("status" => "success", "message" => "Tarefas obtidas com sucesso.", "data" => $tasks);
                } else {
                    $stmt->close();
                    return array("status" => "info", "message" => "Nenhuma tarefa encontrada.");
                }
            } else {
                return array("status" => "error", "message" => "Não foi possível obter as tarefas.");
            }
        } else {
            return array("status" => "error", "message" => "Erro ao preparar a query.");
        }
    }

    public function create()
    {

        $query = "INSERT INTO " . $this->table_name . " (name, user_id) VALUES (?,?);";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("si", $this->name, $this->user_id);

            if ($stmt->execute()) {
                $affectedRows = $stmt->affected_rows;
                $stmt->close();
                if ($affectedRows > 0) {
                    return array("status" => "success", "message" => "Tarefa criada com sucesso.");
                } else {
                    return array("status" => "error", "message" => "Não foi possível criar a tarefa.");
                }
            } else {
                $stmt->close();
                return array("status" => "error", "message" => "Não foi possível criar a tarefa.");
            }

            $stmt->close();
        }

        return array("status" => "error", "message" => "Erro ao preparar a query.");

    }

    public function update()
    {
        if (empty($this->id) || empty($this->user_id)) {
            return array("status" => "error", "message" => "Dados Incompletos.");
        }

        if (!empty($this->name) && !empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET status = ?, name = ? WHERE id = ? AND user_id = ?;";
        } elseif (!empty($this->id) && !empty($this->name) && empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET name = ? WHERE id = ? AND user_id = ?;";
        } elseif (!empty($this->id) && empty($this->name) && !empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ? AND user_id = ?;";
        } else {
            return array("status" => "error", "message" => "Dados Incompletos.");
        }

        if ($stmt = $this->conn->prepare($query)) {
            if (!empty($this->name) && !empty($this->status)) {
                $stmt->bind_param("ssii", $this->status, $this->name, $this->id, $this->user_id);
            } elseif (!empty($this->id) && !empty($this->name) && empty($this->status)) {
                $stmt->bind_param("sii", $this->name, $this->id, $this->user_id);
            } elseif (!empty($this->id) && empty($this->name) && !empty($this->status)) {
                $stmt->bind_param("sii", $this->status, $this->id, $this->user_id);
            }

            if ($stmt->execute()) {
                $affectedRows = $stmt->affected_rows;
                $stmt->close();

                if ($affectedRows > 0) {
                    return array("status" => "success", "message" => "Tarefa atualizada com sucesso.");
                } else {
                    return array("status" => "info", "message" => "Nenhuma alteração foi feita.");
                }
            } else {
                return array("status" => "error", "message" => "Não foi possível atualizar a tarefa.");
            }
        } else {
            return array("status" => "error", "message" => "Erro ao preparar a query.");
        }
    }
    public function deleteTask()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ? AND user";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $this->id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return array("status" => "success", "message" => "Tarefa excluída com sucesso.");
                } else {
                    $stmt->close();
                    return array("status" => "error", "message" => "Não foi possível atualizar a tarefa.");
                }
            } else {
                $stmt->close();
                return array("status" => "error", "message" => "Não foi possível atualizar a tarefa.");
            }
        }
        return array("status" => "error", "message" => "Não foi possível atualizar a tarefa.");
    }

}
