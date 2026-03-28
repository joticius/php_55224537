<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadística — Promedio, Mediana y Moda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #0f1117;
            --surface:  #181c27;
            --card:     #1e2333;
            --border:   #2c3249;
            --text:     #e8eaf6;
            --muted:    #6b7399;
            --pro:      #06d6a0;   /* promedio — verde menta */
            --med:      #f7b731;   /* mediana  — amarillo */
            --mod:      #ee5a8e;   /* moda     — rosa */
            --pro-bg:   rgba(6,214,160,0.08);
            --med-bg:   rgba(247,183,49,0.08);
            --mod-bg:   rgba(238,90,142,0.08);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            padding: 3rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Glow de fondo */
        body::before {
            content: '';
            position: fixed;
            width: 600px; height: 600px;
            background: radial-gradient(ellipse, rgba(6,214,160,0.06) 0%, transparent 70%);
            top: -200px; left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
        }

        .wrapper {
            width: 100%;
            max-width: 720px;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        header { margin-bottom: 2.5rem; }

        .eyebrow {
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--pro);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .eyebrow::before {
            content: '';
            display: inline-block;
            width: 28px; height: 2px;
            background: var(--pro);
            border-radius: 2px;
        }

        h1 {
            font-size: clamp(2rem, 5.5vw, 3.2rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.08;
        }

        h1 em { font-style: normal; color: var(--pro); }

        .subtitle {
            margin-top: 0.6rem;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Card principal */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        /* Instrucción */
        .instruccion {
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 1rem;
            padding: 0.6rem 0.9rem;
            background: rgba(108,119,153,0.08);
            border-left: 3px solid var(--border);
            border-radius: 0 6px 6px 0;
            line-height: 1.5;
        }

        .instruccion strong { color: var(--text); }

        /* Textarea */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        textarea {
            width: 100%;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'JetBrains Mono', monospace;
            font-size: 1rem;
            padding: 0.9rem 1rem;
            resize: vertical;
            min-height: 80px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            line-height: 1.6;
        }

        textarea::placeholder { color: var(--muted); font-size: 0.85rem; }

        textarea:focus {
            border-color: var(--pro);
            box-shadow: 0 0 0 3px rgba(6,214,160,0.1);
        }

        /* Chips de ejemplo */
        .ejemplos {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-bottom: 1.25rem;
        }

        .ej-label {
            font-size: 0.68rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            width: 100%;
        }

        .chip {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chip:hover {
            border-color: var(--pro);
            color: var(--pro);
        }

        /* Botón */
        .btn {
            width: 100%;
            background: var(--pro);
            color: #0a1a15;
            border: none;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-height: 0.03em;
            padding: 0.85rem;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }

        .btn:hover  { opacity: 0.85; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        /* Error */
        .error {
            margin-top: 0.75rem;
            background: rgba(255,80,80,0.08);
            border: 1px solid rgba(255,80,80,0.3);
            color: #ff6b6b;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
        }

        /* ======= RESULTADOS ======= */
        .resultados {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.45s ease both;
        }

        @media (max-width: 560px) {
            .resultados { grid-template-columns: 1fr; }
        }

        .stat-card {
            border-radius: 14px;
            border: 1.5px solid var(--border);
            padding: 1.25rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: 0.06;
        }

        .stat-card.pro { border-color: rgba(6,214,160,0.35); background: var(--pro-bg); }
        .stat-card.med { border-color: rgba(247,183,49,0.35); background: var(--med-bg); }
        .stat-card.mod { border-color: rgba(238,90,142,0.35); background: var(--mod-bg); }

        .stat-icon { font-size: 1.4rem; margin-bottom: 0.4rem; }

        .stat-name {
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.6rem;
            font-weight: 600;
            line-height: 1;
        }

        .stat-card.pro .stat-value { color: var(--pro); }
        .stat-card.med .stat-value { color: var(--med); }
        .stat-card.mod .stat-value { color: var(--mod); }

        .stat-sub {
            font-size: 0.7rem;
            color: var(--muted);
            margin-top: 0.35rem;
        }

        /* Serie ordenada */
        .detalle-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            animation: fadeUp 0.5s ease both;
        }

        .detalle-titulo {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detalle-titulo span {
            display: inline-block;
            width: 8px; height: 8px;
            border-radius: 50%;
        }

        /* Números como burbujas */
        .burbuja-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
        }

        .burbuja {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.82rem;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--text);
            transition: all 0.15s;
        }

        .burbuja.es-moda {
            border-color: rgba(238,90,142,0.5);
            background: var(--mod-bg);
            color: var(--mod);
            font-weight: 600;
        }

        .burbuja.es-mediana {
            border-color: rgba(247,183,49,0.5);
            background: var(--med-bg);
            color: var(--med);
            font-weight: 600;
        }

        /* Tabla de frecuencias */
        .tabla-freq {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            font-family: 'JetBrains Mono', monospace;
        }

        .tabla-freq th {
            text-align: left;
            font-size: 0.68rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            font-family: 'Outfit', sans-serif;
            padding: 0.4rem 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .tabla-freq td {
            padding: 0.45rem 0.75rem;
            border-bottom: 1px solid rgba(44,50,73,0.5);
            color: var(--text);
        }

        .tabla-freq tr:last-child td { border-bottom: none; }

        .tabla-freq .freq-bar-cell { width: 40%; }

        .freq-bar-wrap {
            background: var(--bg);
            border-radius: 4px;
            height: 8px;
            width: 100%;
            overflow: hidden;
        }

        .freq-bar {
            height: 100%;
            border-radius: 4px;
            background: var(--muted);
            transition: width 0.4s ease;
        }

        .freq-bar.es-moda { background: var(--mod); }

        .badge-moda {
            font-size: 0.65rem;
            font-family: 'Outfit', sans-serif;
            background: var(--mod-bg);
            color: var(--mod);
            border: 1px solid rgba(238,90,142,0.3);
            padding: 0.1rem 0.5rem;
            border-radius: 10px;
            margin-left: 0.4rem;
        }

        /* MVC footer */
        .mvc-footer {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .mvc-pill {
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            color: var(--muted);
        }
    </style>
</head>
<body>
<div class="wrapper">

    <header>
        <div class="eyebrow">Aplicación MVC — PHP</div>
        <h1>Estadística<br><em>Descriptiva</em></h1>
        <p class="subtitle">Calcula el promedio, la mediana y la moda de cualquier serie de números reales.</p>
    </header>

    <!-- Formulario -->
    <div class="card">
        <div class="instruccion">
            Ingresa tus números separados por <strong>coma</strong>, <strong>punto y coma</strong> o <strong>espacio</strong>.<br>
            Para decimales usa punto: <strong>3.14</strong>. Puedes ingresar hasta 100 números.
        </div>

        <form method="POST" action="">

            <div class="form-group">
                <label class="form-label" for="numeros">Serie de números</label>
                <textarea
                    id="numeros"
                    name="numeros"
                    placeholder="Ej: 4, 7, 13, 2, 7, 9, 4, 7, 3.5"
                ><?= $datos['rawInput'] ?></textarea>
            </div>

            <!-- Ejemplos rápidos -->
            <div class="ejemplos">
                <span class="ej-label">Ejemplos →</span>
                <button type="button" class="chip" onclick="usar('4, 7, 13, 2, 7, 9, 4, 7, 3')">Con moda clara</button>
                <button type="button" class="chip" onclick="usar('1, 2, 3, 4, 5, 6, 7, 8, 9, 10')">Sin moda (1–10)</button>
                <button type="button" class="chip" onclick="usar('2.5, 3.7, 1.1, 2.5, 4.8, 3.7')">Con decimales</button>
                <button type="button" class="chip" onclick="usar('10, 20, 20, 30, 30, 40')">Bimodal</button>
            </div>

            <button type="submit" class="btn">Calcular estadísticas →</button>

            <?php if (!empty($datos['error'])): ?>
                <div class="error">⚠ <?= htmlspecialchars($datos['error']) ?></div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($datos['ejecutado']):
        $numeros   = $datos['numeros'];
        $ordenados = $datos['ordenados'];
        $moda      = $datos['moda'];
        $total     = count($numeros);
        $mediana   = $datos['mediana'];

        // Índice(s) central(es) para resaltar mediana
        sort($ordenados);
        $mitad = intdiv($total, 2);
        $idxMediana = ($total % 2 === 1) ? [$mitad] : [$mitad - 1, $mitad];

        // Set de modas para resaltado rápido
        $setModas = array_map('strval', $moda['modas']);
    ?>

    <!-- Tarjetas de resultados -->
    <div class="resultados">

        <!-- Promedio -->
        <div class="stat-card pro">
            <div class="stat-icon">📊</div>
            <div class="stat-name">Promedio</div>
            <div class="stat-value"><?= number_format($datos['promedio'], 2) ?></div>
            <div class="stat-sub">Media aritmética de <?= $total ?> números</div>
        </div>

        <!-- Mediana -->
        <div class="stat-card med">
            <div class="stat-icon">📍</div>
            <div class="stat-name">Mediana</div>
            <div class="stat-value"><?= number_format($mediana, 2) ?></div>
            <div class="stat-sub">
                <?= $total % 2 === 1 ? 'Valor central' : 'Promedio de 2 centrales' ?>
            </div>
        </div>

        <!-- Moda -->
        <div class="stat-card mod">
            <div class="stat-icon">🎯</div>
            <div class="stat-name">Moda</div>
            <?php if ($moda['sinModa']): ?>
                <div class="stat-value" style="font-size:1rem; padding-top:0.3rem">Sin moda</div>
                <div class="stat-sub">Todos los valores son únicos</div>
            <?php elseif (count($moda['modas']) === 1): ?>
                <div class="stat-value"><?= number_format($moda['modas'][0], 2) ?></div>
                <div class="stat-sub">Frecuencia: <?= $moda['maxFrecuencia'] ?> veces</div>
            <?php else: ?>
                <div class="stat-value" style="font-size:1.1rem">
                    <?= implode(', ', array_map(fn($m) => number_format($m, 2), $moda['modas'])) ?>
                </div>
                <div class="stat-sub">Multimodal — <?= $moda['maxFrecuencia'] ?> veces c/u</div>
            <?php endif; ?>
        </div>

    </div>

    <!-- Serie ordenada con resaltado -->
    <div class="detalle-card">
        <div class="detalle-titulo">
            <span style="background: var(--med)"></span>
            Serie ordenada — Mediana resaltada en amarillo, Moda en rosa
        </div>
        <div class="burbuja-row">
            <?php foreach ($ordenados as $i => $n):
                $esModa    = !$moda['sinModa'] && in_array((string)$n, $setModas);
                $esMediana = in_array($i, $idxMediana);
                // Mediana tiene prioridad visual solo si no es también moda
                $clase = $esModa ? 'burbuja es-moda' : ($esMediana ? 'burbuja es-mediana' : 'burbuja');
            ?>
                <span class="<?= $clase ?>"><?= number_format($n, 2) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Tabla de frecuencias -->
    <div class="detalle-card">
        <div class="detalle-titulo">
            <span style="background: var(--mod)"></span>
            Tabla de frecuencias
        </div>
        <table class="tabla-freq">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Frecuencia</th>
                    <th class="freq-bar-cell">Distribución</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $maxFreq = $moda['maxFrecuencia'];
                foreach ($moda['frecuencias'] as $valor => $freq):
                    $esModa = !$moda['sinModa'] && in_array($valor, $setModas);
                    $pct = round(($freq / $maxFreq) * 100);
                ?>
                <tr>
                    <td>
                        <?= number_format((float)$valor, 2) ?>
                        <?php if ($esModa): ?>
                            <span class="badge-moda">moda</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $freq ?> <?= $freq === 1 ? 'vez' : 'veces' ?></td>
                    <td class="freq-bar-cell">
                        <div class="freq-bar-wrap">
                            <div class="freq-bar <?= $esModa ? 'es-moda' : '' ?>"
                                 style="width: <?= $pct ?>%"></div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>

    <div class="mvc-footer">
        <span class="mvc-pill">📦 Model → EstadisticaModel.php</span>
        <span class="mvc-pill">🎨 View → index.php</span>
        <span class="mvc-pill">⚙ Controller → EstadisticaController.php</span>
    </div>

</div>

<script>
    function usar(texto) {
        document.getElementById('numeros').value = texto;
    }
</script>
</body>
</html>
