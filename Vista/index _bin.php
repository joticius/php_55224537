<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decimal → Binario</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600;700&family=IBM+Plex+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:      #0d0d0d;
            --surf:    #141414;
            --card:    #1a1a1a;
            --border:  #2a2a2a;
            --text:    #f0f0f0;
            --muted:   #555;
            --dim:     #888;
            --on:      #39ff14;   /* verde neón — bit 1 */
            --off:     #1c2a1c;   /* apagado    — bit 0 */
            --accent:  #39ff14;
            --gold:    #ffd60a;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'IBM Plex Sans', sans-serif;
            min-height: 100vh;
            padding: 3rem 1.5rem 5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Scanlines sutiles de fondo */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(255,255,255,0.013) 2px,
                rgba(255,255,255,0.013) 4px
            );
            pointer-events: none; z-index: 0;
        }

        .wrapper {
            width: 100%; max-width: 680px;
            position: relative; z-index: 1;
            animation: up .5s ease both;
        }

        @keyframes up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Header ── */
        header { margin-bottom: 2.5rem; }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .68rem; letter-spacing: .22em;
            text-transform: uppercase; color: var(--accent);
            margin-bottom: .8rem;
        }

        h1 {
            font-family: 'IBM Plex Mono', monospace;
            font-size: clamp(2rem, 5.5vw, 3.4rem);
            font-weight: 700; letter-spacing: -.02em; line-height: 1.08;
        }

        h1 .dec { color: var(--dim); }
        h1 .arrow { color: var(--muted); margin: 0 .3rem; }
        h1 .bin { color: var(--accent); text-shadow: 0 0 24px rgba(57,255,20,.4); }

        .subtitle { margin-top: .7rem; color: var(--dim); font-size: .88rem; line-height: 1.6; }

        /* ── Card ── */
        .card {
            background: var(--surf);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.75rem;
            margin-bottom: 1.25rem;
        }

        /* ── Input row ── */
        .form-label {
            display: block; font-size: .68rem; font-weight: 500;
            letter-spacing: .15em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .5rem;
            font-family: 'IBM Plex Mono', monospace;
        }

        .input-row { display: flex; gap: .75rem; margin-bottom: 1.1rem; }

        input[type="number"] {
            flex: 1;
            background: var(--bg); border: 1.5px solid var(--border);
            border-radius: 8px; color: var(--text);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 1.4rem; font-weight: 600;
            padding: .65rem 1rem; outline: none;
            transition: border-color .2s, box-shadow .2s;
            -moz-appearance: textfield;
        }
        input[type="number"]::-webkit-inner-spin-button { opacity: .3; }
        input[type="number"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(57,255,20,.12);
        }

        .btn {
            background: var(--accent); color: #050e00;
            border: none; border-radius: 8px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: .9rem; font-weight: 700;
            padding: .65rem 1.3rem; cursor: pointer;
            white-space: nowrap;
            transition: opacity .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 0 16px rgba(57,255,20,.25);
        }
        .btn:hover  { opacity: .85; transform: translateY(-1px); box-shadow: 0 0 24px rgba(57,255,20,.4); }
        .btn:active { transform: translateY(0); }

        /* Chips de ejemplo */
        .chips { display: flex; flex-wrap: wrap; gap: .4rem; }
        .chip-label {
            font-size: .63rem; color: var(--muted); text-transform: uppercase;
            letter-spacing: .1em; width: 100%;
            font-family: 'IBM Plex Mono', monospace;
        }
        .chip {
            font-family: 'IBM Plex Mono', monospace; font-size: .72rem;
            background: transparent; border: 1px solid var(--border);
            color: var(--dim); padding: .28rem .75rem;
            border-radius: 20px; cursor: pointer; transition: all .2s;
        }
        .chip:hover { border-color: var(--accent); color: var(--accent); }

        .error {
            margin-top: .75rem;
            background: rgba(255,50,50,.07); border: 1px solid rgba(255,50,50,.3);
            color: #ff6b6b; border-radius: 8px; padding: .7rem 1rem; font-size: .85rem;
        }

        /* ── Resultado grande ── */
        .resultado-wrap {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 14px; padding: 1.75rem;
            margin-bottom: 1.25rem;
            animation: up .4s ease both;
        }

        .res-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .63rem; letter-spacing: .2em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .5rem;
        }

        .res-ecuacion {
            font-family: 'IBM Plex Mono', monospace;
            font-size: clamp(1rem, 3vw, 1.3rem);
            color: var(--dim); margin-bottom: 1rem;
            word-break: break-all; line-height: 1.5;
        }
        .res-ecuacion .num-dec { color: var(--gold); font-weight: 600; }
        .res-ecuacion .num-bin { color: var(--accent); font-weight: 700;
            text-shadow: 0 0 12px rgba(57,255,20,.5); }

        .res-agrupado {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .8rem; color: var(--muted);
            letter-spacing: .08em;
        }
        .res-agrupado span { color: var(--accent); opacity: .7; }

        /* ── Visualizador de bits ── */
        .bits-wrap {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 14px; padding: 1.5rem;
            margin-bottom: 1.25rem;
            animation: up .45s ease both;
        }

        .section-title {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .63rem; letter-spacing: .18em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 1rem;
        }

        .bits-row {
            display: flex; flex-wrap: wrap; gap: .5rem;
            justify-content: center;
        }

        .bit-box {
            display: flex; flex-direction: column;
            align-items: center; gap: .3rem;
        }

        .bit-led {
            width: 46px; height: 52px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 1.3rem; font-weight: 700;
            transition: all .3s ease;
            border: 1.5px solid;
        }

        .bit-led.on {
            background: rgba(57,255,20,.12);
            border-color: var(--on);
            color: var(--on);
            box-shadow: 0 0 12px rgba(57,255,20,.35), inset 0 0 8px rgba(57,255,20,.1);
        }

        .bit-led.off {
            background: var(--off);
            border-color: #1e3a1e;
            color: #2a5c2a;
        }

        .bit-pos {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .6rem; color: var(--muted);
        }

        /* Separador de nibbles */
        .nibble-sep {
            width: 1px; height: 52px;
            background: var(--border);
            align-self: flex-start;
            margin-top: 0;
        }

        /* ── Tabla de pasos ── */
        .pasos-wrap {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 14px; padding: 1.5rem;
            margin-bottom: 1.25rem;
            animation: up .5s ease both;
        }

        .tabla-pasos {
            width: 100%; border-collapse: collapse;
            font-family: 'IBM Plex Mono', monospace; font-size: .85rem;
        }

        .tabla-pasos th {
            text-align: left; padding: .45rem .75rem;
            font-size: .63rem; letter-spacing: .14em;
            text-transform: uppercase; color: var(--muted);
            font-family: 'IBM Plex Sans', sans-serif;
            border-bottom: 1px solid var(--border);
        }

        .tabla-pasos td {
            padding: .5rem .75rem;
            border-bottom: 1px solid rgba(42,42,42,.5);
            color: var(--dim);
        }

        .tabla-pasos tr:last-child td { border-bottom: none; }

        .tabla-pasos .col-res  { color: var(--text); font-weight: 600; }
        .tabla-pasos .residuo-1 {
            color: var(--accent); font-weight: 700;
            text-shadow: 0 0 8px rgba(57,255,20,.4);
        }
        .tabla-pasos .residuo-0 { color: var(--muted); }

        .lectura-hint {
            margin-top: .75rem; padding: .6rem .75rem;
            background: rgba(57,255,20,.04); border: 1px solid rgba(57,255,20,.12);
            border-radius: 8px; font-size: .78rem; color: var(--muted);
            font-family: 'IBM Plex Mono', monospace;
        }
        .lectura-hint strong { color: var(--accent); }

        /* ── MVC footer ── */
        .mvc-footer {
            display: flex; justify-content: center;
            flex-wrap: wrap; gap: .5rem; margin-top: .5rem;
        }
        .mvc-pill {
            font-family: 'IBM Plex Mono', monospace;
            font-size: .6rem; letter-spacing: .08em;
            text-transform: uppercase; padding: .25rem .75rem;
            border-radius: 20px; border: 1px solid var(--border);
            color: var(--muted);
        }

        @media(max-width: 480px) {
            .input-row { flex-direction: column; }
            .btn { width: 100%; }
            .bit-led { width: 38px; height: 44px; font-size: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <header>
        <div class="eyebrow">// Aplicación MVC — PHP</div>
        <h1>
            <span class="dec">DEC</span>
            <span class="arrow">→</span>
            <span class="bin">BIN</span>
        </h1>
        <p class="subtitle">Convierte cualquier número entero a su representación binaria con el proceso paso a paso.</p>
    </header>

    <!-- Formulario -->
    <div class="card">
        <form method="POST" action="">
            <label class="form-label" for="numero">// ingresa un entero</label>
            <div class="input-row">
                <input type="number" id="numero" name="numero"
                    placeholder="Ej: 42"
                    value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>">
                <button type="submit" class="btn">Convertir →</button>
            </div>

            <div class="chips">
                <span class="chip-label">// ejemplos</span>
                <?php foreach ([0, 1, 10, 42, 127, 255, 1024, -13] as $ej): ?>
                    <button type="button" class="chip"
                        onclick="document.getElementById('numero').value=<?= $ej ?>">
                        <?= $ej ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($datos['error'])): ?>
                <div class="error">⚠ <?= htmlspecialchars($datos['error']) ?></div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($datos['ejecutado']):
        $n       = $datos['numero'];
        $binario = $datos['binario'];
        $negativo = $n < 0;
        $bits_str = ltrim($binario, '-');
    ?>

    <!-- Resultado -->
    <div class="resultado-wrap">
        <div class="res-label">// resultado</div>
        <div class="res-ecuacion">
            <span class="num-dec"><?= $n ?></span>
            <span style="color:var(--muted)"> en decimal es </span>
            <span class="num-bin"><?= $binario ?></span>
            <span style="color:var(--muted)"> en binario</span>
        </div>
        <div class="res-agrupado">
            agrupado en nibbles: <span><?= $datos['agrupado'] ?></span>
            &nbsp;|&nbsp; <?= $datos['bits'] ?> bit<?= $datos['bits'] !== 1 ? 's' : '' ?> significativos
        </div>
    </div>

    <!-- Visualizador de LEDs -->
    <div class="bits-wrap">
        <div class="section-title">// visualizador de bits</div>
        <div class="bits-row">
            <?php
                // Pad a múltiplo de 4
                $pad   = (4 - (strlen($bits_str) % 4)) % 4;
                $padded = str_repeat('0', $pad) . $bits_str;
                $total  = strlen($padded);

                foreach (str_split($padded) as $i => $bit):
                    // Separador entre nibbles (excepto al inicio)
                    if ($i > 0 && $i % 4 === 0):
            ?>
                    <div class="nibble-sep"></div>
            <?php  endif; ?>
                    <div class="bit-box">
                        <div class="bit-led <?= $bit === '1' ? 'on' : 'off' ?>"><?= $bit ?></div>
                        <div class="bit-pos"><?= ($total - 1 - $i) ?></div>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pasos de conversión (solo positivos) -->
    <?php if (!$negativo && $n > 0): ?>
    <div class="pasos-wrap">
        <div class="section-title">// proceso — división sucesiva por 2</div>
        <table class="tabla-pasos">
            <thead>
                <tr>
                    <th>Paso</th>
                    <th>Dividendo</th>
                    <th>÷ 2 = Cociente</th>
                    <th>Residuo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['pasos'] as $i => $p): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="col-res"><?= $p['dividendo'] ?></td>
                    <td><?= $p['cociente'] ?></td>
                    <td class="<?= $p['residuo'] === 1 ? 'residuo-1' : 'residuo-0' ?>">
                        <?= $p['residuo'] ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="lectura-hint">
            💡 Lee los residuos de <strong>abajo hacia arriba</strong> → obtienes
            <strong><?= $binario ?></strong>
        </div>
    </div>
    <?php elseif ($n === 0): ?>
    <div class="pasos-wrap">
        <div class="section-title">// nota</div>
        <p style="color:var(--muted);font-size:.85rem;font-family:'IBM Plex Mono',monospace;">
            El número 0 en cualquier base es <span style="color:var(--accent)">0</span>.
        </p>
    </div>
    <?php elseif ($negativo): ?>
    <div class="pasos-wrap">
        <div class="section-title">// nota sobre negativos</div>
        <p style="color:var(--muted);font-size:.85rem;font-family:'IBM Plex Mono',monospace;line-height:1.6;">
            Para números negativos se muestra la representación del valor absoluto
            <span style="color:var(--accent)"><?= abs($n) ?> = <?= ltrim($binario,'-') ?></span>
            con el signo <span style="color:var(--accent)">−</span> como prefijo.<br>
            En hardware real se usaría complemento a dos.
        </p>
    </div>
    <?php endif; ?>

    <?php endif; ?>

    <div class="mvc-footer">
        <span class="mvc-pill">📦 Model → BinarioModel.php</span>
        <span class="mvc-pill">🎨 View → index.php</span>
        <span class="mvc-pill">⚙ Controller → BinarioController.php</span>
    </div>

</div>
</body>
</html>
