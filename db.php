<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "truco";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]));
}
?>