<?php
session_start();
header("Content-Type: application/json");
require_once "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
    $nosotros = $data['nosotros'];
    $puntosNosotros = $data['puntosNosotros'];
    $ellos = $data['ellos'];
    $puntosEllos = $data['puntosEllos'];
    $limite = $data['limite'];
    $ganador = $data['ganador'];

    $stmt = $conn->prepare("INSERT INTO partida (idUsuario, equipo_nosotros, puntos_nosotros, equipo_ellos, puntos_ellos, limite_puntos, ganador) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisiis", $idUsuario, $nosotros, $puntosNosotros, $ellos, $puntosEllos, $limite, $ganador);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Partida guardada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado o datos inválidos"]);
}

$conn->close();
?>