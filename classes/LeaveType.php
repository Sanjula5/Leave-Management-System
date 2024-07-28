<?php
class LeaveType {
    private $conn;
    private $table_name = "leave_types";

    public $id;
    public $type_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (type_name) VALUES (:type_name)";

        $stmt = $this->conn->prepare($query);

        $this->type_name = htmlspecialchars(strip_tags($this->type_name));

        $stmt->bindParam(":type_name", $this->type_name);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT id, type_name FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
