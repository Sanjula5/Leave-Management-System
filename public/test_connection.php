<?php
include_once '../config/Database.php';

$database = new Database();
$conn = $database->getConnection();

if($conn) {
    echo "Connection successful.";
} else {
    echo "Connection failed.";
}
?>
