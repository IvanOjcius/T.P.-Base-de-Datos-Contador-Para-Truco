<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anotador de Truco</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .tablero {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .equipo {
            width: 45%;
        }
        .nombre-equipo {
            font-size: 1.5em;
            font-weight: bold;
            border: none;
            border-bottom: 2px dashed #ccc;
            text-align: center;
            width: 90%;
            margin-bottom: 10px;
            padding: 5px;
            background: transparent;
        }
        .nombre-equipo:focus {
            outline: none;
            border-bottom: 2px solid #333;
        }
        .contenedor-fosforos {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            min-height: 150px;
            margin: 15px 0;
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
        }
        canvas {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div style="text-align: center; margin-bottom: 15px;">
        <button id="btn-limite" onclick="cambiarLimite()">Modo: A 30 Puntos</button>
        <button onclick="reiniciarPartida()">Reiniciar</button>
    </div>

    <div class="tablero">
        
        <div class="equipo">
            <input type="text" id="nombre-nosotros" class="nombre-equipo" value="Nosotros">
            <h3 id="num-nosotros">0 Puntos</h3>
            <div id="fosforos-nosotros" class="contenedor-fosforos"></div>
            <div>
                <button onclick="sumar('nosotros', 1)">+1</button>
                <button onclick="sumar('nosotros', -1)">-1</button>
            </div>
        </div>
        
        <div class="equipo">
            <input type="text" id="nombre-ellos" class="nombre-equipo" value="Ellos">
            <h3 id="num-ellos">0 Puntos</h3>
            <div id="fosforos-ellos" class="contenedor-fosforos"></div>
            <div>
                <button onclick="sumar('ellos', 1)">+1</button>
                <button onclick="sumar('ellos', -1)">-1</button>
            </div>
        </div>

    </div>

    <a href="anotador.html" style="margin-top: 20px; display: inline-block;">
        <button type="button">Volver al Inicio</button>
    </a>

  <script>
    let puntosNosotros = 0;
    let puntosEllos = 0;
    let limitePuntos = 30;

    function cambiarLimite() {
        if (puntosNosotros > 0 || puntosEllos > 0) {
            if (!confirm("Si cambias el modo se reiniciará la partida. ¿Continuar?")) return;
        }
        limitePuntos = (limitePuntos === 30) ? 15 : 30;
        document.getElementById("btn-limite").innerText = "Modo: A " + limitePuntos + " Puntos";
        reiniciarPartida();
    }

    function sumar(equipo, cantidad) {
        if (equipo === 'nosotros') {
            puntosNosotros = Math.max(0, puntosNosotros + cantidad);
            dibujarPuntos('nosotros', puntosNosotros);
            verificarGanador(document.getElementById('nombre-nosotros').value || "Nosotros", puntosNosotros);
        } else {
            puntosEllos = Math.max(0, puntosEllos + cantidad);
            dibujarPuntos('ellos', puntosEllos);
            verificarGanador(document.getElementById('nombre-ellos').value || "Ellos", puntosEllos);
        }
    }

    function dibujarPuntos(equipo, puntos) {
        document.getElementById('num-' + equipo).innerText = puntos + " Puntos";
        const contenedor = document.getElementById('fosforos-' + equipo);
        contenedor.innerHTML = '';

        let puntosRestantes = puntos;

        while (puntosRestantes > 0) {
            let puntosEnEsteCuadro = Math.min(5, puntosRestantes);
            
            let canvas = document.createElement('canvas');
            canvas.width = 60;
            canvas.height = 60;
            let ctx = canvas.getContext('2d');
            
            ctx.strokeStyle = '#d32f2f';
            ctx.lineWidth = 4;
            ctx.lineCap = 'round';

            if (puntosEnEsteCuadro >= 1) { ctx.beginPath(); ctx.moveTo(10, 10); ctx.lineTo(10, 50); ctx.stroke(); }
            if (puntosEnEsteCuadro >= 2) { ctx.beginPath(); ctx.moveTo(10, 10); ctx.lineTo(50, 10); ctx.stroke(); }
            if (puntosEnEsteCuadro >= 3) { ctx.beginPath(); ctx.moveTo(50, 10); ctx.lineTo(50, 50); ctx.stroke(); }
            if (puntosEnEsteCuadro >= 4) { ctx.beginPath(); ctx.moveTo(10, 50); ctx.lineTo(50, 50); ctx.stroke(); }
            if (puntosEnEsteCuadro >= 5) { ctx.beginPath(); ctx.moveTo(10, 10); ctx.lineTo(50, 50); ctx.stroke(); }

            contenedor.appendChild(canvas);
            puntosRestantes -= puntosEnEsteCuadro;
        }
    }

    function verificarGanador(nombreEquipo, puntos) {
        if (puntos >= limitePuntos) {
            setTimeout(() => { 
                alert("¡Ganó " + nombreEquipo + "!"); 
                // AQUÍ SE CONECTA CON PHP AL GANAR:
                guardarPartidaBD(nombreEquipo);
            }, 100);
        }
    }

    // NUEVA FUNCIÓN: Envía los puntos actuales al archivo PHP usando Fetch API
    function guardarPartidaBD(ganador) {
        const datosPartida = {
            nosotros: document.getElementById('nombre-nosotros').value || "Nosotros",
            puntosNosotros: puntosNosotros,
            ellos: document.getElementById('nombre-ellos').value || "Ellos",
            puntosEllos: puntosEllos,
            limite: limitePuntos,
            ganador: ganador
        };

        fetch('guardar_partida.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosPartida)
        })
        .then(res => res.json())
        .then(res => console.log(res.message))
        .catch(err => console.error("Error al guardar:", err));
    }

    function reiniciarPartida() {
        puntosNosotros = 0;
        puntosEllos = 0;
        dibujarPuntos('nosotros', 0);
        dibujarPuntos('ellos', 0);
    }

    reiniciarPartida();
</script>

</body>
</html>