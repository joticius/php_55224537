<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Árbol Binario — Recorridos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;900&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #111418;
            --surf:     #181c22;
            --card:     #1e232b;
            --border:   #2b3040;
            --text:     #e8eaf0;
            --muted:    #5a6280;
            --dim:      #8891aa;

            --pre:      #f59e0b;   /* ámbar   — preorden  */
            --ino:      #34d399;   /* esmeralda — inorden */
            --post:     #a78bfa;   /* violeta — postorden */

            --node-bg:  #1e2a3a;
            --node-brd: #3b82f6;
            --node-txt: #93c5fd;
            --edge:     #334155;

            --shadow:   0 4px 30px rgba(0,0,0,0.35);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Raleway', sans-serif;
            min-height: 100vh;
            padding: 3rem 1.5rem 5rem;
            display: flex; flex-direction: column; align-items: center;
        }

        /* Fondo con puntos */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(rgba(59,130,246,0.07) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .wrapper {
            width: 100%; max-width: 780px;
            position: relative; z-index: 1;
            animation: up .5s ease both;
        }

        @keyframes up {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ── Header ── */
        header { margin-bottom: 2.5rem; }

        .kicker {
            font-size: .68rem; letter-spacing: .22em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .75rem;
            display: flex; align-items: center; gap: .6rem;
        }
        .kicker::before { content:''; width:24px; height:2px; background:var(--node-brd); border-radius:2px; }

        h1 {
            font-size: clamp(2rem, 5.5vw, 3.3rem);
            font-weight: 900; letter-spacing: -.03em; line-height: 1.07;
        }

        h1 .hi { color: var(--node-brd);
            text-shadow: 0 0 30px rgba(59,130,246,.4); }

        .subtitle { margin-top: .65rem; color: var(--muted); font-size: .88rem; line-height: 1.6; }

        /* ── Card ── */
        .card {
            background: var(--surf);
            border: 1px solid var(--border);
            border-radius: 16px; padding: 1.75rem;
            box-shadow: var(--shadow); margin-bottom: 1.25rem;
        }

        .card-title {
            font-size: .68rem; font-weight: 600; letter-spacing: .16em;
            text-transform: uppercase; color: var(--muted); margin-bottom: 1.25rem;
        }

        /* ── Formulario ── */
        .campos { display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.25rem; }

        .campo label {
            display: flex; align-items: center; gap: .5rem;
            font-size: .7rem; font-weight: 600; letter-spacing: .14em;
            text-transform: uppercase; color: var(--muted); margin-bottom: .4rem;
        }

        .badge {
            font-size: .6rem; padding: .15rem .5rem; border-radius: 10px;
            font-weight: 700; letter-spacing: .05em;
        }
        .badge-pre  { background: rgba(245,158,11,.15); color: var(--pre); border:1px solid rgba(245,158,11,.3); }
        .badge-ino  { background: rgba(52,211,153,.12); color: var(--ino); border:1px solid rgba(52,211,153,.3); }
        .badge-post { background: rgba(167,139,250,.12); color: var(--post); border:1px solid rgba(167,139,250,.3); }

        input[type="text"] {
            width: 100%;
            background: var(--bg); border: 1.5px solid var(--border);
            border-radius: 9px; color: var(--text);
            font-family: 'Fira Code', monospace; font-size: .95rem;
            padding: .65rem 1rem; outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        input[type="text"]::placeholder { color: var(--muted); font-size: .82rem; }
        input[type="text"]:focus { border-color: var(--node-brd); box-shadow: 0 0 0 3px rgba(59,130,246,.12); }

        /* Nota opcional */
        .opcional { font-size: .65rem; color: var(--muted); margin-left: auto; font-style: italic; }

        /* Chips ejemplos */
        .chips { display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:1.25rem; }
        .chip-label { font-size:.62rem; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; width:100%; }
        .chip {
            font-family:'Fira Code',monospace; font-size:.7rem;
            background:transparent; border:1px solid var(--border);
            color:var(--dim); padding:.28rem .75rem; border-radius:20px;
            cursor:pointer; transition:all .2s;
        }
        .chip:hover { border-color:var(--node-brd); color:var(--node-brd); }

        /* Botón */
        .btn {
            width:100%; background:var(--node-brd); color:#fff;
            border:none; border-radius:9px;
            font-family:'Raleway',sans-serif; font-weight:700; font-size:1rem;
            padding:.85rem; cursor:pointer;
            box-shadow: 0 0 20px rgba(59,130,246,.3);
            transition:opacity .2s, transform .15s;
        }
        .btn:hover  { opacity:.85; transform:translateY(-1px); }
        .btn:active { transform:translateY(0); }

        .error {
            margin-top:.75rem; background:rgba(255,50,50,.07);
            border:1px solid rgba(255,50,50,.3); color:#ff6b6b;
            border-radius:8px; padding:.7rem 1rem; font-size:.85rem;
        }

        /* ── Árbol SVG ── */
        .arbol-wrap {
            background: var(--surf); border:1px solid var(--border);
            border-radius:16px; padding:1.5rem;
            box-shadow:var(--shadow); margin-bottom:1.25rem;
            animation: up .45s ease both;
            overflow-x: auto;
        }

        .arbol-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:1rem;
        }

        .arbol-titulo {
            font-size:.68rem; font-weight:600; letter-spacing:.16em;
            text-transform:uppercase; color:var(--muted);
        }

        .modo-badge {
            font-size:.62rem; font-family:'Fira Code',monospace;
            padding:.2rem .65rem; border-radius:10px;
            background:rgba(59,130,246,.1); color:var(--node-brd);
            border:1px solid rgba(59,130,246,.25);
        }

        svg.tree {
            width: 100%; display:block; overflow:visible;
        }

        /* Nodos SVG */
        .node-circle {
            fill: var(--node-bg);
            stroke: var(--node-brd);
            stroke-width: 2;
            filter: drop-shadow(0 0 8px rgba(59,130,246,.35));
        }

        .node-text {
            font-family: 'Raleway', sans-serif;
            font-weight: 700; font-size: 16px;
            fill: var(--node-txt);
            text-anchor: middle; dominant-baseline: central;
        }

        .edge-line { stroke: var(--edge); stroke-width: 1.5; }

        /* ── Recorridos resultado ── */
        .recorridos-grid {
            display: grid; grid-template-columns: repeat(3,1fr);
            gap: 1rem; margin-bottom: 1.25rem;
            animation: up .5s ease both;
        }
        @media(max-width:560px){ .recorridos-grid{ grid-template-columns:1fr; } }

        .rec-card {
            border-radius:12px; border:1.5px solid var(--border);
            padding:1.1rem;
        }
        .rec-card.pre  { border-color:rgba(245,158,11,.3);  background:rgba(245,158,11,.05); }
        .rec-card.ino  { border-color:rgba(52,211,153,.25); background:rgba(52,211,153,.04); }
        .rec-card.post { border-color:rgba(167,139,250,.25);background:rgba(167,139,250,.04); }

        .rec-nombre {
            font-size:.63rem; font-weight:700; letter-spacing:.15em;
            text-transform:uppercase; margin-bottom:.6rem;
        }
        .rec-card.pre  .rec-nombre { color:var(--pre); }
        .rec-card.ino  .rec-nombre { color:var(--ino); }
        .rec-card.post .rec-nombre { color:var(--post); }

        .rec-serie {
            display:flex; flex-wrap:wrap; gap:.3rem; align-items:center;
        }

        .rec-elem {
            font-family:'Fira Code',monospace; font-size:.8rem; font-weight:600;
            padding:.2rem .5rem; border-radius:5px;
        }
        .rec-card.pre  .rec-elem { background:rgba(245,158,11,.12); color:var(--pre); }
        .rec-card.ino  .rec-elem { background:rgba(52,211,153,.1);  color:var(--ino); }
        .rec-card.post .rec-elem { background:rgba(167,139,250,.1); color:var(--post); }

        .rec-flecha { color:var(--muted); font-size:.75rem; }

        /* ── MVC footer ── */
        .mvc-footer { display:flex; justify-content:center; flex-wrap:wrap; gap:.5rem; margin-top:.5rem; }
        .mvc-pill {
            font-size:.6rem; letter-spacing:.08em; text-transform:uppercase;
            padding:.25rem .75rem; border-radius:20px;
            border:1px solid var(--border); color:var(--muted);
        }
    </style>
</head>
<body>
<div class="wrapper">

    <header>
        <div class="kicker">Aplicación MVC — PHP</div>
        <h1>Árbol <span class="hi">Binario</span><br>por Recorridos</h1>
        <p class="subtitle">
            Ingresa mínimo dos recorridos (preorden, inorden o postorden) y el árbol se construye automáticamente.
        </p>
    </header>

    <!-- Formulario -->
    <div class="card">
        <div class="card-title">// ingresa los recorridos</div>
        <form method="POST" action="">
            <div class="campos">

                <div class="campo">
                    <label>
                        <span class="badge badge-pre">PRE</span>
                        Preorden
                        <span class="opcional">opcional si tienes inorden+postorden</span>
                    </label>
                    <input type="text" name="preorden"
                        placeholder="Ej: A B D E C  ó  A→B→D→E→C"
                        value="<?= $datos['rawPre'] ?>">
                </div>

                <div class="campo">
                    <label>
                        <span class="badge badge-ino">INO</span>
                        Inorden
                        <span class="opcional">opcional si tienes preorden+postorden</span>
                    </label>
                    <input type="text" name="inorden"
                        placeholder="Ej: D B E A C  ó  D→B→E→A→C"
                        value="<?= $datos['rawIn'] ?>">
                </div>

                <div class="campo">
                    <label>
                        <span class="badge badge-post">POST</span>
                        Postorden
                        <span class="opcional">opcional si tienes preorden+inorden</span>
                    </label>
                    <input type="text" name="postorden"
                        placeholder="Ej: D E B C A  ó  D→E→B→C→A"
                        value="<?= $datos['rawPost'] ?>">
                </div>

            </div>

            <!-- Ejemplos -->
            <div class="chips">
                <span class="chip-label">// ejemplos rápidos</span>
                <button type="button" class="chip"
                    onclick="cargar('A B D E C','D B E A C','')">
                    Pre+Ino (del enunciado)
                </button>
                <button type="button" class="chip"
                    onclick="cargar('','D B E A C','D E B C A')">
                    Ino+Post (del enunciado)
                </button>
                <button type="button" class="chip"
                    onclick="cargar('A B D E C','','D E B C A')">
                    Pre+Post
                </button>
                <button type="button" class="chip"
                    onclick="cargar('1 2 4 5 3 6 7','4 2 5 1 6 3 7','4 5 2 6 7 3 1')">
                    Árbol numérico
                </button>
            </div>

            <button type="submit" class="btn">Construir árbol →</button>

            <?php if (!empty($datos['error'])): ?>
                <div class="error">⚠ <?= htmlspecialchars($datos['error']) ?></div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($datos['ejecutado']):
        $svgData = $datos['svg'];
        $nodos   = $svgData['nodos'];
        $altura  = $svgData['altura'];
        $total   = count($nodos);

        // Convertir % a coordenadas SVG absolutas
        $W = 700; $PAD = 40;
        foreach ($nodos as &$n) {
            $n['cx'] = round($PAD + ($n['x'] / 100) * ($W - 2 * $PAD));
            $n['cy'] = $n['y'];
        }
        unset($n);
    ?>

    <!-- Árbol SVG -->
    <div class="arbol-wrap">
        <div class="arbol-header">
            <div class="arbol-titulo">// árbol construido</div>
            <div class="modo-badge">Construido con: <?= htmlspecialchars($datos['modo']) ?></div>
        </div>

        <svg class="tree" viewBox="0 0 <?= $W ?> <?= $altura ?>"
             xmlns="http://www.w3.org/2000/svg">

            <!-- Aristas primero (debajo de los nodos) -->
            <?php foreach ($nodos as $n):
                if ($n['padre'] === -1) continue;
                $p = $nodos[$n['padre']];
            ?>
                <line class="edge-line"
                      x1="<?= $p['cx'] ?>" y1="<?= $p['cy'] ?>"
                      x2="<?= $n['cx'] ?>" y2="<?= $n['cy'] ?>"/>
            <?php endforeach; ?>

            <!-- Nodos -->
            <?php foreach ($nodos as $n): ?>
                <circle class="node-circle" cx="<?= $n['cx'] ?>" cy="<?= $n['cy'] ?>" r="22"/>
                <text class="node-text" x="<?= $n['cx'] ?>" y="<?= $n['cy'] ?>"><?= htmlspecialchars($n['val']) ?></text>
            <?php endforeach; ?>

        </svg>
    </div>

    <!-- Recorridos calculados -->
    <div class="recorridos-grid">

        <div class="rec-card pre">
            <div class="rec-nombre">Preorden</div>
            <div class="rec-serie">
                <?php foreach ($datos['preorden'] as $i => $v): ?>
                    <span class="rec-elem"><?= htmlspecialchars($v) ?></span>
                    <?php if ($i < count($datos['preorden']) - 1): ?>
                        <span class="rec-flecha">→</span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="rec-card ino">
            <div class="rec-nombre">Inorden</div>
            <div class="rec-serie">
                <?php foreach ($datos['inorden'] as $i => $v): ?>
                    <span class="rec-elem"><?= htmlspecialchars($v) ?></span>
                    <?php if ($i < count($datos['inorden']) - 1): ?>
                        <span class="rec-flecha">→</span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="rec-card post">
            <div class="rec-nombre">Postorden</div>
            <div class="rec-serie">
                <?php foreach ($datos['postorden'] as $i => $v): ?>
                    <span class="rec-elem"><?= htmlspecialchars($v) ?></span>
                    <?php if ($i < count($datos['postorden']) - 1): ?>
                        <span class="rec-flecha">→</span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <?php endif; ?>

    <div class="mvc-footer">
        <span class="mvc-pill">📦 Model → ArbolModel.php</span>
        <span class="mvc-pill">🎨 View → index.php</span>
        <span class="mvc-pill">⚙ Controller → ArbolController.php</span>
    </div>
</div>

<script>
function cargar(pre, ino, post) {
    document.querySelectorAll('input[type="text"]')[0].value = pre;
    document.querySelectorAll('input[type="text"]')[1].value = ino;
    document.querySelectorAll('input[type="text"]')[2].value = post;
}
</script>
</body>
</html>
