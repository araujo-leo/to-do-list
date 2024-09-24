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
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);

        if ($stmt) {
            if ($stmt->num_rows > 0) {
                $result = $stmt->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                return $result;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            return false;
        }
    }

    public function create()
    {

        $query = "INSERT INTO " . $this->table_name . " (name, user_id) VALUES (?,?);";

        var_dump($this->user_id);

        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("si", $this->name, $this->user_id);

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

            $stmt->close();
        }

        return false;
    }

    public function update()
    {
        if (empty($this->id)) {
            return false;
        }

        if (!empty($this->name) && !empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET status = ?, name = ? WHERE id = ?;";
        } elseif (!empty($this->id) && !empty($this->name) && empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET name = ? WHERE id = ?;";
        } elseif (!empty($this->id) && empty($this->name) && !empty($this->status)) {
            $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?;";
        } else {
            return false;
        }

        if ($stmt = $this->conn->prepare($query)) {
            if (!empty($this->name) && !empty($this->status)) {
                $stmt->bind_param("isi", $this->status, $this->name, $this->id);
            } elseif (!empty($this->id) && !empty($this->name) && empty($this->status)) {
                $stmt->bind_param("si", $this->name, $this->id);
            } elseif (!empty($this->id) && empty($this->name) && !empty($this->status)) {
                $stmt->bind_param("ii", $this->status, $this->id);
            }

            if ($stmt->execute()) {
                return $stmt->affected_rows > 0;
            } else {
                return false;
            }

            $stmt->close();
        }

        return false;
    }

    public function deleteTask()
    {
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
