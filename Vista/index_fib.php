<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci & Factorial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #f5f2eb;
            --card:      #ffffff;
            --border:    #ddd8cc;
            --text:      #1a1814;
            --muted:     #8a8478;
            --fib-color: #1d4ed8;
            --fib-light: #dbeafe;
            --fac-color: #b45309;
            --fac-light: #fef3c7;
            --shadow:    0 4px 24px rgba(0,0,0,0.08);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Space Grotesk', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem 1.5rem;
        }

        /* Círculos decorativos de fondo */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 420px; height: 420px;
            background: radial-gradient(circle, #bfdbfe44, transparent 70%);
            top: -100px; left: -100px;
        }
        body::after {
            width: 320px; height: 320px;
            background: radial-gradient(circle, #fde68a33, transparent 70%);
            bottom: -80px; right: -80px;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 680px;
            animation: slideUp 0.5s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        header { text-align: center; margin-bottom: 2.5rem; }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            border: 1px solid var(--border);
            background: var(--card);
            padding: 0.3rem 0.9rem;
            border-radius: 20px;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        h1 .fib { color: var(--fib-color); }
        h1 .sep { color: var(--muted); font-weight: 400; margin: 0 0.3rem; }
        h1 .fac { color: var(--fac-color); }

        .subtitle {
            margin-top: 0.6rem;
            color: var(--muted);
            font-size: 0.9rem;
        }

        /* Card */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow);
        }

        /* Selector de operación */
        .op-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .op-option {
            position: relative;
            cursor: pointer;
        }

        .op-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }

        .op-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            padding: 1.1rem 0.5rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .op-label .op-icon {
            font-size: 1.6rem;
            line-height: 1;
        }

        .op-label .op-name {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .op-label .op-desc {
            font-size: 0.72rem;
            color: var(--muted);
            font-family: 'Fira Code', monospace;
        }

        /* Fibonacci seleccionado */
        .op-option input[value="fibonacci"]:checked + .op-label {
            border-color: var(--fib-color);
            background: var(--fib-light);
            color: var(--fib-color);
        }

        .op-option input[value="fibonacci"]:checked + .op-label .op-desc {
            color: #3b82f6;
        }

        /* Factorial seleccionado */
        .op-option input[value="factorial"]:checked + .op-label {
            border-color: var(--fac-color);
            background: var(--fac-light);
            color: var(--fac-color);
        }

        .op-option input[value="factorial"]:checked + .op-label .op-desc {
            color: #d97706;
        }

        .op-option .op-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        /* Input número */
        .input-group {
            margin-bottom: 1.25rem;
        }

        .input-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        .input-row {
            display: flex;
            gap: 0.75rem;
        }

        input[type="number"] {
            flex: 1;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: 'Fira Code', monospace;
            font-size: 1.3rem;
            font-weight: 600;
            padding: 0.7rem 1rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="number"]:focus {
            border-color: var(--fib-color);
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }

        input[type="number"]::-webkit-inner-spin-button { opacity: 0.5; }

        button[type="submit"] {
            background: var(--text);
            color: var(--bg);
            border: none;
            border-radius: 10px;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.7rem 1.4rem;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            white-space: nowrap;
        }

        button[type="submit"]:hover  { opacity: 0.82; transform: translateY(-1px); }
        button[type="submit"]:active { transform: translateY(0); }

        /* Error */
        .error-box {
            background: #fff1f1;
            border: 1.5px solid #fca5a5;
            border-radius: 10px;
            color: #b91c1c;
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
        }

        /* ===================== RESULTADO ===================== */
        .resultado {
            margin-top: 2rem;
            animation: slideUp 0.4s ease both;
        }

        .resultado-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .resultado-titulo {
            font-weight: 700;
            font-size: 1rem;
        }

        .resultado-titulo.fib { color: var(--fib-color); }
        .resultado-titulo.fac { color: var(--fac-color); }

        .resultado-meta {
            font-size: 0.75rem;
            color: var(--muted);
            font-family: 'Fira Code', monospace;
        }

        /* Serie Fibonacci — burbujas */
        .serie-fib {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .fib-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.2rem;
        }

        .fib-num {
            background: var(--fib-light);
            border: 1.5px solid #93c5fd;
            color: var(--fib-color);
            font-family: 'Fira Code', monospace;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.35rem 0.65rem;
            border-radius: 8px;
            min-width: 44px;
            text-align: center;
            position: relative;
        }

        .fib-idx {
            font-size: 0.6rem;
            color: var(--muted);
            font-family: 'Fira Code', monospace;
        }

        .fib-arrow {
            font-size: 0.75rem;
            color: #93c5fd;
            align-self: center;
            margin-top: -1.2rem;
        }

        /* Tabla Factorial */
        .tabla-factorial {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Fira Code', monospace;
            font-size: 0.88rem;
        }

        .tabla-factorial thead tr {
            background: var(--fac-light);
        }

        .tabla-factorial th {
            padding: 0.6rem 1rem;
            text-align: left;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--fac-color);
            font-family: 'Space Grotesk', sans-serif;
            border-bottom: 2px solid #fcd34d;
        }

        .tabla-factorial td {
            padding: 0.55rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        .tabla-factorial tr:last-child td {
            border-bottom: none;
            background: var(--fac-light);
            font-weight: 600;
            color: var(--fac-color);
        }

        .tabla-factorial .col-op {
            color: var(--muted);
        }

        /* Resultado final grande */
        .resultado-final {
            margin-top: 1.25rem;
            padding: 1rem 1.25rem;
            background: var(--bg);
            border-radius: 10px;
            border: 1.5px solid var(--border);
            display: flex;
            align-items: baseline;
            gap: 0.75rem;
        }

        .resultado-final .label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--muted);
            white-space: nowrap;
        }

        .resultado-final .valor {
            font-family: 'Fira Code', monospace;
            font-weight: 600;
            font-size: 1.1rem;
            word-break: break-all;
        }

        .valor.fib { color: var(--fib-color); }
        .valor.fac { color: var(--fac-color); }

        /* MVC tags */
        .mvc-row {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .mvc-tag {
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            border: 1px solid var(--border);
            color: var(--muted);
            background: var(--card);
        }

        @media (max-width: 480px) {
            .input-row { flex-direction: column; }
            button[type="submit"] { width: 100%; }
            .op-label .op-desc { display: none; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <header>
        <div class="badge">⚙ Aplicación MVC — PHP</div>
        <h1>
            <span class="fib">Fibonacci</span>
            <span class="sep">&amp;</span>
            <span class="fac">Factorial</span>
        </h1>
        <p class="subtitle">Ingresa un número, elige la operación y obtén la serie completa.</p>
    </header>

    <div class="card">
        <form method="POST" action="">

            <!-- Selector de operación -->
            <div class="op-selector">

                <label class="op-option">
                    <input type="radio" name="operacion" value="fibonacci"
                        <?= (($_POST['operacion'] ?? 'fibonacci') === 'fibonacci') ? 'checked' : '' ?>>
                    <div class="op-label">
                        <span class="op-icon">🌀</span>
                        <span class="op-name">Fibonacci</span>
                        <span class="op-desc">F(n) = F(n-1) + F(n-2)</span>
                    </div>
                </label>

                <label class="op-option">
                    <input type="radio" name="operacion" value="factorial"
                        <?= (($_POST['operacion'] ?? '') === 'factorial') ? 'checked' : '' ?>>
                    <div class="op-label">
                        <span class="op-icon">✖</span>
                        <span class="op-name">Factorial</span>
                        <span class="op-desc">n! = 1 × 2 × ... × n</span>
                    </div>
                </label>

            </div>

            <!-- Input numérico -->
            <div class="input-group">
                <label for="numero">Número</label>
                <div class="input-row">
                    <input
                        type="number"
                        id="numero"
                        name="numero"
                        min="0"
                        max="50"
                        placeholder="Ej: 10"
                        value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>"
                        required
                    >
                    <button type="submit">Calcular →</button>
                </div>
            </div>

            <!-- Error -->
            <?php if (!empty($datos['error'])): ?>
                <div class="error-box">⚠ <?= htmlspecialchars($datos['error']) ?></div>
            <?php endif; ?>

        </form>

        <!-- ========== RESULTADO ========== -->
        <?php if ($datos['ejecutado']): ?>

            <?php if ($datos['operacion'] === 'fibonacci'): ?>
                <!-- FIBONACCI -->
                <div class="resultado">
                    <div class="resultado-header">
                        <div class="resultado-titulo fib">🌀 Serie de Fibonacci</div>
                        <div class="resultado-meta"><?= count($datos['serie']) ?> términos</div>
                    </div>

                    <div class="serie-fib">
                        <?php foreach ($datos['serie'] as $i => $num): ?>
                            <div class="fib-item">
                                <div class="fib-num"><?= number_format($num, 0, '', '.') ?></div>
                                <div class="fib-idx">F(<?= $i ?>)</div>
                            </div>
                            <?php if ($i < count($datos['serie']) - 1): ?>
                                <div class="fib-arrow" style="align-self:center; margin-top:0;">→</div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="resultado-final">
                        <span class="label">Último término:</span>
                        <span class="valor fib">
                            F(<?= $datos['numero'] - 1 ?>) = <?= number_format(end($datos['serie']), 0, '', '.') ?>
                        </span>
                    </div>
                </div>

            <?php elseif ($datos['operacion'] === 'factorial'): ?>
                <!-- FACTORIAL -->
                <div class="resultado">
                    <div class="resultado-header">
                        <div class="resultado-titulo fac">✖ Factorial — <?= $datos['numero'] ?>!</div>
                        <div class="resultado-meta"><?= $datos['numero'] ?> pasos</div>
                    </div>

                    <table class="tabla-factorial">
                        <thead>
                            <tr>
                                <th>Paso</th>
                                <th>Operación</th>
                                <th>Resultado parcial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datos['pasos'] as $paso): ?>
                                <tr>
                                    <td><?= $paso['num'] ?></td>
                                    <td class="col-op">
                                        <?php
                                            // Construir la operación visual: 1 × 2 × ... × i
                                            $ops = [];
                                            for ($k = 1; $k <= $paso['num']; $k++) $ops[] = $k;
                                            echo implode(' × ', $ops);
                                        ?>
                                    </td>
                                    <td><?= number_format($paso['resultado'], 0, '', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="resultado-final">
                        <span class="label"><?= $datos['numero'] ?>! =</span>
                        <span class="valor fac">
                            <?= number_format(end($datos['pasos'])['resultado'], 0, '', '.') ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <div class="mvc-row">
        <span class="mvc-tag">📦 Model → MatematicaModel.php</span>
        <span class="mvc-tag">🎨 View → index.php</span>
        <span class="mvc-tag">⚙ Controller → MatematicaController.php</span>
    </div>

</div>
</body>
</html>
