<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['usuario'];
    $contrasenia = $_POST['contrasena'];

    $consulta = $conn->prepare("SELECT id, nombre FROM usuario WHERE nombre = ? AND contrasenia = ?");
    $consulta->bind_param("ss", $nombre, $contrasenia);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['idUsuario'] = $fila['id'];
        $_SESSION['nombreUsuario'] = $fila['nombre'];
        header("Location: anotador.php");
        exit();
    } else {
        echo "<script>
                alert('Usuario o contraseña incorrectos.');
                window.location.href = 'iniciodesesion.html';
              </script>";
    }
    $consulta->close();
}
$conn->close();
?>