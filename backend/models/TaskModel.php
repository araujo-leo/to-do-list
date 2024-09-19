<?php
class TaskModel {
    private $conn;
    private $table_name = "todos";

    public $id;
    public $name;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function list() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);
    
        if ($stmt) {
            if ($stmt->num_rows > 0) {
                $result = $stmt->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                return $result; 
            } else {
                return $result;
                $stmt->close();
                return false; 
            }
        } else {
            return false; 
        }
    }

    public function create() {

        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (?);";


        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("s", $this->name);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return true;
                }else{
                    $stmt->close();
                    return false; 
                }
            } else {
                $stmt->close();
                return false;
            }

            $stmt->close();
        }

        return false;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?;";

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("si", $this->status, $this->id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return true;
                }else{
                    $stmt->close();
                    return false;
                }
            } else {
                $stmt->close();
                return false;
            }

            $stmt->close();
        }

        return false;
    }

    public function deleteTask() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $this->id);
    
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    return true; 
                } else {
                    $stmt->close();
                    return false; 
                }
            } else {
                $stmt->close();
                return false; 
            }
        }
    
        return false; 
    }

}