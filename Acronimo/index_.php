<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Acrónimos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #0a0a0f;
            --surface:  #13131a;
            --border:   #2a2a3a;
            --accent:   #e8ff47;
            --accent2:  #47ffe8;
            --text:     #f0f0f8;
            --muted:    #6b6b88;
            --error:    #ff6b6b;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow-x: hidden;
        }

        
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(232,255,71,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(232,255,71,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .wrapper {
            width: 100%;
            max-width: 680px;
            animation: fadeUp 0.6s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Encabezado */
        header {
            margin-bottom: 2.5rem;
        }

        .tag {
            display: inline-block;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 0.2rem 0.7rem;
            border-radius: 2px;
            margin-bottom: 1rem;
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.2rem, 6vw, 3.5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.02em;
        }

        h1 span {
            color: var(--accent);
        }

        .subtitle {
            margin-top: 0.75rem;
            color: var(--muted);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2));
        }

        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        label {
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        input[type="text"] {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: 'DM Mono', monospace;
            font-size: 1rem;
            padding: 0.85rem 1rem;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        input[type="text"]::placeholder { color: var(--muted); }

        input[type="text"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(232,255,71,0.1);
        }

        
        .ejemplos {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .ejemplo-label {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            width: 100%;
        }

        .chip {
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chip:hover {
            border-color: var(--accent2);
            color: var(--accent2);
        }

        
        button[type="submit"] {
            width: 100%;
            background: var(--accent);
            color: #0a0a0f;
            border: none;
            border-radius: 8px;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 0.9rem;
            cursor: pointer;
            transition: transform 0.15s, opacity 0.15s;
        }

        button[type="submit"]:hover  { opacity: 0.88; transform: translateY(-1px); }
        button[type="submit"]:active { transform: translateY(0); }

        
        .error-box {
            background: rgba(255,107,107,0.08);
            border: 1px solid var(--error);
            border-radius: 8px;
            color: var(--error);
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
        }

        
        .resultado {
            margin-top: 1.5rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.5rem;
            animation: fadeUp 0.4s ease both;
        }

        .resultado-label {
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }

        .frase-original {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 1rem;
            word-break: break-word;
        }

        .frase-original strong { color: var(--text); }

        .acronimo-display {
            font-family: 'Syne', sans-serif;
            font-size: clamp(3rem, 10vw, 5rem);
            font-weight: 800;
            letter-spacing: 0.08em;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        
        .mvc-badge {
            display: flex;
            gap: 0.5rem;
            margin-top: 2rem;
            justify-content: center;
        }

        .mvc-item {
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            border: 1px solid var(--border);
            color: var(--muted);
        }

        .mvc-item.m { border-color: #7c3aed44; color: #a78bfa; }
        .mvc-item.v { border-color: #0891b244; color: #67e8f9; }
        .mvc-item.c { border-color: #d9772044; color: #fbbf24; }
    </style>
</head>
<body>

<div class="wrapper">
    <header>
        <div class="tag">Aplicación MVC</div>
        <h1>Generador de<br><span>Acrónimos</span></h1>
        <p class="subtitle">
            Ingresa una frase y obtén su acrónimo al instante.<br>
            Los guiones ( - ) son tratados como separadores de palabras.
        </p>
    </header>

    <div class="card">
        <form method="POST" action="">

            <div class="form-group">
                <label for="frase">Ingresa tu frase</label>
                <input
                    type="text"
                    id="frase"
                    name="frase"
                    placeholder="Ej: As Soon As Possible"
                    value="<?= htmlspecialchars($_POST['frase'] ?? '') ?>"
                    autocomplete="off"
                >
            </div>

            
            <div class="ejemplos">
                <span class="ejemplo-label">Ejemplos rápidos →</span>
                <button type="button" class="chip" onclick="usarEjemplo('As Soon As Possible')">As Soon As Possible</button>
                <button type="button" class="chip" onclick="usarEjemplo('Liquid-crystal display')">Liquid-crystal display</button>
                <button type="button" class="chip" onclick="usarEjemplo(&quot;Thank George It\'s Friday!&quot;)">Thank George It's Friday!</button>
                <button type="button" class="chip" onclick="usarEjemplo('Portable Network Graphics')">Portable Network Graphics</button>
            </div>

            <button type="submit">Generar Acrónimo →</button>

            <?php if (!empty($datos['error'])): ?>
                <div class="error-box">⚠ <?= $datos['error'] ?></div>
            <?php endif; ?>

            <?php if (!empty($datos['acronimo'])): ?>
                <div class="resultado">
                    <div class="resultado-label">Frase original</div>
                    <div class="frase-original"><strong><?= $datos['frase'] ?></strong></div>
                    <div class="resultado-label">Acrónimo</div>
                    <div class="acronimo-display"><?= $datos['acronimo'] ?></div>
                </div>
            <?php endif; ?>

        </form>
    </div>

    <div class="mvc-badge">
        <div class="mvc-item m">Model → AcronimoModel.php</div>
        <div class="mvc-item v">View → index.php</div>
        <div class="mvc-item c">Controller → AcronimoController.php</div>
    </div>
</div>

<script>
    function usarEjemplo(texto) {
        document.getElementById('frase').value = texto;
    }
</script>

</body>
</html>
