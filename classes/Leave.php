<?php
class Leave {
    private $conn;
    private $table_name = "leaves";

    public $id;
    public $user_id;
    public $type_id;
    public $start_date;
    public $end_date;
    public $reason;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function readLeaves($user_id = null) {
        $query = "SELECT l.id, u.username, lt.type_name, l.start_date, l.end_date, l.reason, l.status
                  FROM " . $this->table_name . " l
                  JOIN users u ON l.user_id = u.id
                  JOIN leave_types lt ON l.type_id = lt.id";
        
        if ($user_id !== null) {
            $query .= " WHERE l.user_id = :user_id";
        }

        $stmt = $this->conn->prepare($query);
        
        if ($user_id !== null) {
            $stmt->bindParam(':user_id', $user_id);
        }
        
        $stmt->execute();

        return $stmt;
    }


    public function applyLeave() {
        $query = "INSERT INTO " . $this->table_name . " (user_id, type_id, start_date, end_date, reason, status) 
                  VALUES (:user_id, :type_id, :start_date, :end_date, :reason, :status)";
        $stmt = $this->conn->prepare($query);

        $this->status = 'pending';

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':start_date', $this->start_date);
        $stmt->bindParam(':end_date', $this->end_date);
        $stmt->bindParam(':reason', $this->reason);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function getLeaveTypes() {
        $query = "SELECT id, type_name FROM leave_types";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }


    public function readLeavesByType($type_id = null) {
        $query = "SELECT l.id, u.username, lt.type_name, l.start_date, l.end_date, l.reason, l.status
                  FROM " . $this->table_name . " l
                  JOIN users u ON l.user_id = u.id
                  JOIN leave_types lt ON l.type_id = lt.id";
        
        if ($type_id !== null && $type_id !== '') {
            $query .= " WHERE l.type_id = :type_id";
        }


        $query .= " ORDER BY FIELD(l.status, 'pending', 'approved', 'rejected'), l.start_date ASC";

        $stmt = $this->conn->prepare($query);
        
        if ($type_id !== null && $type_id !== '') {
            $stmt->bindParam(':type_id', $type_id);
        }
        
        $stmt->execute();

        return $stmt;
    }


    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
