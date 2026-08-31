<?php
require_once "db.php";

// Se cambió "partidas" por "partida"
$result = $conn->query("SELECT * FROM partida ORDER BY fecha DESC");

$ganadasTotal = 0;
$perdidasTotal = 0;

$partidas = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $partidas[] = $row;
        if ($row['ganador'] === $row['equipo_nosotros']) {
            $ganadasTotal++;
        } else {
            $perdidasTotal++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidas Anteriores</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="historial">
    <h1>Historial de Partidas</h1>
    
    <div class="marcador-global">
        <span class="ganador">Ganadas (Nosotros): <?php echo $ganadasTotal; ?></span> | 
        <span>Perdidas: <?php echo $perdidasTotal; ?></span>
    </div>

    <div style="margin-top: 15px;">
        <?php foreach ($partidas as $p): ?>
            <div class="partida-row">
                <span>
                    <strong><?php echo htmlspecialchars($p['equipo_nosotros']); ?></strong> (<?php echo $p['puntos_nosotros']; ?>) 
                    vs 
                    <strong><?php echo htmlspecialchars($p['equipo_ellos']); ?></strong> (<?php echo $p['puntos_ellos']; ?>)
                </span>
                <span class="ganador">Ganador: <?php echo htmlspecialchars($p['ganador']); ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="index.html" style="margin-top: 20px;">
        <button type="button">Volver al Inicio</button>
    </a>
</div>

</body>
</html>