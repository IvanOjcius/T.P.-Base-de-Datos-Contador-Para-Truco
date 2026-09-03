<?php
session_start();

// Conexión a la base de datos (o include('conexion.php'); si tenés el archivo aparte)
$conexion = new mysqli("localhost", "root", "", "truco");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Reemplazás la variable $sql acá:
$sql = "SELECT u.nombre, COUNT(p.id) AS victorias
        FROM usuario u
        INNER JOIN partida p ON u.id = p.idUsuario
        WHERE p.ganador = p.equipo_nosotros
        GROUP BY u.id, u.nombre
        ORDER BY victorias DESC
        LIMIT 5";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anotador de truco</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .pantalla-principal {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
        }
        .contenedor {
            flex: 1;
        }
        .top-ranking {
            width: 250px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .top-ranking ol {
            padding-left: 20px;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="pantalla-principal">
    <div class="contenedor">
        <h1>Anotador de truco</h1>
        
        <button type="button" onclick="continuarPartida()">Continuar</button>

        <a href="nueva_partida.php?modo=nueva">
            <button type="button">Nueva partida</button>
        </a>

        <a href="partidas_anteriores.php">
            <button type="button">Partidas anteriores</button>
        </a>
    </div>

    <div class="top-ranking">
        <h2>Top 5 Ganadores</h2>
        <ol>
            <?php 
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($fila['nombre']) . " - " . $fila['victorias'] . " victorias</li>";
                }
            } else {
                echo "<p>Sin datos de victorias</p>";
            }
            ?>
        </ol>
    </div>
</div>

<script>
function continuarPartida() {
    if (localStorage.getItem("partida_activa")) {
        window.location.href = "nueva_partida.php?modo=continuar";
    } else {
        alert("No hay ninguna partida guardada para continuar.");
    }
}
</script>

</body>   
</html>