<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nuevo_usuario'];
    $contrasenia = $_POST['nueva_contrasena'];

    $consulta_existe = $conn->prepare("SELECT id FROM usuario WHERE nombre = ?");
    $consulta_existe->bind_param("s", $nombre);
    $consulta_existe->execute();
    $consulta_existe->store_result();

    if ($consulta_existe->num_rows > 0) {
        echo "<script>
                alert('El nombre de usuario ya está en uso.');
                window.location.href = 'registro.html';
              </script>";
    } else {
        $insertar = $conn->prepare("INSERT INTO usuario (nombre, contrasenia) VALUES (?, ?)");
        $insertar->bind_param("ss", $nombre, $contrasenia);

        if ($insertar->execute()) {
            $_SESSION['idUsuario'] = $insertar->insert_id;
            $_SESSION['nombreUsuario'] = $nombre;
            
            header("Location: anotador.php");
            exit();
        } else {
            echo "Error al registrar: " . $conn->error;
        }
        $insertar->close();
    }
    $consulta_existe->close();
}
$conn->close();
?>