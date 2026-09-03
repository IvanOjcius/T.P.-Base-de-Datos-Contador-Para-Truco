<?php
require_once "db.php";

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
    
    <div class="marcador-global" style="text-align: center; margin-bottom: 15px; font-weight: bold;">
        <span style="color: #22a01e;">Ganadas (Nosotros): <?php echo $ganadasTotal; ?></span> | 
        <span style="color: #ff4c4c;">Perdidas: <?php echo $perdidasTotal; ?></span>
    </div>

    <div style="margin-top: 15px;">
        <?php if (empty($partidas)): ?>
            <p style="text-align: center; color: #666; font-style: italic;">No hay partidas registradas.</p>
        <?php else: ?>
            <?php foreach ($partidas as $p): ?>
                <div class="partida-row" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #ddd;">
                    
                    <span style="flex: 2;">
                        <strong><?php echo htmlspecialchars($p['equipo_nosotros']); ?></strong> (<?php echo $p['puntos_nosotros']; ?>) 
                        vs 
                        <strong><?php echo htmlspecialchars($p['equipo_ellos']); ?></strong> (<?php echo $p['puntos_ellos']; ?>)
                    </span>
                    
                    <!-- Indicador de Buenas -->
                    <span style="flex: 1; text-align: center; font-size: 0.9rem; color: #555;">
                        Buenas: 
                        <?php if (isset($p['buenas']) && $p['buenas'] == 1): ?>
                            <span style="color: #22a01e; font-weight: bold; font-size: 1.1rem;">✓</span>
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </span>

                    <span style="flex: 1; text-align: right; color: #22a01e; font-weight: bold;">
                        <?php echo htmlspecialchars($p['ganador']); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <a href="anotador.php" style="margin-top: 20px; text-align: center;">
        <button type="button" style="margin: 0 auto; display: block;">Volver al Inicio</button>
    </a>
</div>

</body>
</html>