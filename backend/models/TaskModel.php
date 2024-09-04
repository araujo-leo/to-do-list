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
                die();
                return $result;
                $stmt->close();
                return false; 
            }
        } else {
            return false; 
        }
    }

}