<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Conjuntos — A ∪ B · A ∩ B · A−B · B−A</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:      #faf8f4;
            --surface: #ffffff;
            --border:  #e4dfd6;
            --text:    #1c1814;
            --muted:   #9a9080;

            --a:       #4f46e5;   /* índigo  — conjunto A */
            --b:       #e5466a;   /* rosa    — conjunto B */
            --ab:      #9333ea;   /* violeta — intersección */

            --a-bg:    rgba(79,70,229,0.08);
            --b-bg:    rgba(229,70,106,0.08);
            --ab-bg:   rgba(147,51,234,0.08);
            --u-bg:    rgba(16,185,129,0.08);
            --u:       #059669;

            --shadow:  0 2px 20px rgba(0,0,0,0.07);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            padding: 3rem 1.5rem 4rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .wrapper { width: 100%; max-width: 780px; animation: up .5s ease both; }

        @keyframes up {
            from { opacity:0; transform:translateY(18px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ── Header ─────────────────────────────────── */
        header { margin-bottom: 2.5rem; }

        .kicker {
            font-size: .7rem; letter-spacing: .18em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .8rem;
            display: flex; align-items: center; gap: .5rem;
        }
        .kicker::after { content:''; flex:1; height:1px; background:var(--border); }

        h1 {
            font-family: 'Fraunces', serif;
            font-size: clamp(2rem, 5.5vw, 3.4rem);
            font-weight: 900; letter-spacing: -.03em; line-height: 1.05;
        }

        h1 .hi-a { color: var(--a); }
        h1 .hi-b { color: var(--b); }

        .subtitle { margin-top:.6rem; color:var(--muted); font-size:.9rem; line-height:1.6; }

        /* ── Card formulario ─────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }
        @media(max-width:520px){ .two-col{ grid-template-columns:1fr; } }

        .field label {
            display: flex; align-items: center; gap: .4rem;
            font-size: .72rem; font-weight: 600;
            letter-spacing: .12em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .45rem;
        }

        .dot {
            display: inline-block; width: 10px; height: 10px;
            border-radius: 50%;
        }
        .dot-a { background: var(--a); }
        .dot-b { background: var(--b); }

        textarea {
            width: 100%; resize: vertical; min-height: 72px;
            background: var(--bg); border: 1.5px solid var(--border);
            border-radius: 10px; color: var(--text);
            font-family: 'JetBrains Mono', monospace; font-size: .95rem;
            padding: .75rem 1rem; outline: none;
            transition: border-color .2s, box-shadow .2s;
            line-height: 1.6;
        }
        textarea::placeholder { color: var(--muted); font-size:.82rem; }
        textarea:focus { border-color: var(--a); box-shadow: 0 0 0 3px rgba(79,70,229,.1); }

        /* Ejemplos rápidos */
        .chips { display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:1.25rem; }
        .chip-label { font-size:.67rem; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; width:100%; }
        .chip {
            font-family:'JetBrains Mono',monospace; font-size:.7rem;
            border:1px solid var(--border); background:transparent; color:var(--muted);
            padding:.28rem .75rem; border-radius:20px; cursor:pointer; transition:all .2s;
        }
        .chip:hover { border-color:var(--a); color:var(--a); }

        /* Botón */
        .btn {
            width:100%; background:var(--text); color:var(--bg);
            border:none; border-radius:10px;
            font-family:'DM Sans',sans-serif; font-weight:600; font-size:1rem;
            padding:.85rem; cursor:pointer; transition:opacity .2s, transform .15s;
        }
        .btn:hover  { opacity:.82; transform:translateY(-1px); }
        .btn:active { transform:translateY(0); }

        .error {
            margin-top:.75rem; background:#fff1f1;
            border:1.5px solid #fca5a5; color:#b91c1c;
            border-radius:8px; padding:.7rem 1rem; font-size:.85rem;
        }

        /* ── Diagrama de Venn SVG ─────────────────────── */
        .venn-wrap {
            background: var(--surface);
            border:1px solid var(--border); border-radius:18px;
            padding:1.5rem; margin-bottom:1.5rem;
            box-shadow:var(--shadow);
            animation: up .5s ease both;
        }

        .venn-titulo {
            font-size:.72rem; font-weight:600; letter-spacing:.13em;
            text-transform:uppercase; color:var(--muted); margin-bottom:1rem;
        }

        svg.venn { width:100%; max-width:520px; display:block; margin:0 auto; }

        /* ── Tarjetas de operaciones ─────────────────── */
        .ops-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            animation: up .55s ease both;
        }
        @media(max-width:520px){ .ops-grid{ grid-template-columns:1fr; } }

        .op-card {
            border-radius:14px; border:1.5px solid var(--border);
            padding:1.25rem;
        }

        .op-card.union        { border-color:rgba(5,150,105,.3);  background:var(--u-bg); }
        .op-card.interseccion { border-color:rgba(147,51,234,.3); background:var(--ab-bg); }
        .op-card.difAB        { border-color:rgba(79,70,229,.3);  background:var(--a-bg); }
        .op-card.difBA        { border-color:rgba(229,70,106,.3); background:var(--b-bg); }

        .op-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:.75rem;
        }

        .op-symbol {
            font-family:'Fraunces',serif; font-size:1.3rem; font-weight:700;
        }
        .op-card.union        .op-symbol { color:var(--u);  }
        .op-card.interseccion .op-symbol { color:var(--ab); }
        .op-card.difAB        .op-symbol { color:var(--a);  }
        .op-card.difBA        .op-symbol { color:var(--b);  }

        .op-name {
            font-size:.68rem; letter-spacing:.12em; text-transform:uppercase;
            color:var(--muted); text-align:right;
        }

        .op-conjunto {
            display:flex; flex-wrap:wrap; gap:.35rem; min-height:32px;
        }

        .elem {
            font-family:'JetBrains Mono',monospace; font-size:.82rem; font-weight:500;
            padding:.25rem .6rem; border-radius:6px;
        }

        .op-card.union        .elem { background:rgba(5,150,105,.12);  color:var(--u);  border:1px solid rgba(5,150,105,.25);  }
        .op-card.interseccion .elem { background:rgba(147,51,234,.12); color:var(--ab); border:1px solid rgba(147,51,234,.25); }
        .op-card.difAB        .elem { background:rgba(79,70,229,.12);  color:var(--a);  border:1px solid rgba(79,70,229,.25);  }
        .op-card.difBA        .elem { background:rgba(229,70,106,.12); color:var(--b);  border:1px solid rgba(229,70,106,.25); }

        .empty-msg {
            font-size:.8rem; color:var(--muted); font-style:italic;
            align-self:center;
        }

        .op-count {
            margin-top:.6rem; font-size:.72rem; color:var(--muted);
            font-family:'JetBrains Mono',monospace;
        }

        /* ── Sets originales ─────────────────────────── */
        .sets-row {
            display:grid; grid-template-columns:1fr 1fr; gap:1rem;
            margin-bottom:1.5rem; animation: up .48s ease both;
        }
        @media(max-width:520px){ .sets-row{ grid-template-columns:1fr; } }

        .set-card {
            border-radius:14px; padding:1.1rem 1.25rem;
            border:1.5px solid var(--border);
        }
        .set-card.a { border-color:rgba(79,70,229,.35); background:var(--a-bg); }
        .set-card.b { border-color:rgba(229,70,106,.35); background:var(--b-bg); }

        .set-title {
            font-family:'Fraunces',serif; font-weight:700; font-size:1.1rem;
            margin-bottom:.6rem;
        }
        .set-card.a .set-title { color:var(--a); }
        .set-card.b .set-title { color:var(--b); }

        .set-elems { display:flex; flex-wrap:wrap; gap:.35rem; }

        .set-card.a .elem { background:rgba(79,70,229,.1); color:var(--a); border:1px solid rgba(79,70,229,.2); }
        .set-card.b .elem { background:rgba(229,70,106,.1); color:var(--b); border:1px solid rgba(229,70,106,.2); }

        /* ── MVC footer ──────────────────────────────── */
        .mvc-footer { display:flex; justify-content:center; flex-wrap:wrap; gap:.5rem; margin-top:.5rem; }
        .mvc-pill {
            font-size:.63rem; letter-spacing:.08em; text-transform:uppercase;
            padding:.25rem .75rem; border-radius:20px;
            border:1px solid var(--border); color:var(--muted);
        }
    </style>
</head>
<body>
<div class="wrapper">

    <header>
        <div class="kicker">Aplicación MVC — PHP</div>
        <h1>Teoría de<br><span class="hi-a">Con</span><span class="hi-b">juntos</span></h1>
        <p class="subtitle">Ingresa dos conjuntos de enteros y calcula unión, intersección y diferencia.</p>
    </header>

    <!-- Formulario -->
    <div class="card">
        <form method="POST" action="">

            <div class="two-col">
                <div class="field">
                    <label><span class="dot dot-a"></span> Conjunto A</label>
                    <textarea name="conjuntoA" placeholder="Ej: 1, 3, 5, 7, 9"><?= $datos['rawA'] ?></textarea>
                </div>
                <div class="field">
                    <label><span class="dot dot-b"></span> Conjunto B</label>
                    <textarea name="conjuntoB" placeholder="Ej: 2, 3, 6, 7, 10"><?= $datos['rawB'] ?></textarea>
                </div>
            </div>

            <div class="chips">
                <span class="chip-label">Ejemplos →</span>
                <button type="button" class="chip"
                    onclick="usar('1 2 3 4 5','3 4 5 6 7')">Solapados</button>
                <button type="button" class="chip"
                    onclick="usar('10 20 30','40 50 60')">Disjuntos</button>
                <button type="button" class="chip"
                    onclick="usar('1 2 3 4 5','1 2 3 4 5')">Iguales</button>
                <button type="button" class="chip"
                    onclick="usar('1 2 3','-3 -2 -1 0 1 2 3 4 5')">Con negativos</button>
            </div>

            <button type="submit" class="btn">Calcular operaciones →</button>

            <?php if (!empty($datos['error'])): ?>
                <div class="error">⚠ <?= htmlspecialchars($datos['error']) ?></div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($datos['ejecutado']):
        $A    = $datos['setA'];
        $B    = $datos['setB'];
        $U    = $datos['union'];
        $I    = $datos['interseccion'];
        $dAB  = $datos['difAB'];
        $dBA  = $datos['difBA'];

        // Helpers para renderizar elementos
        $elems = fn(array $arr) => array_map(fn($n) => "<span class='elem'>$n</span>", $arr);
        $render = fn(array $arr) =>
            count($arr) > 0
            ? implode('', $elems($arr))
            : "<span class='empty-msg'>∅ (conjunto vacío)</span>";
    ?>

    <!-- Conjuntos originales -->
    <div class="sets-row">
        <div class="set-card a">
            <div class="set-title">A = { <?= implode(', ', $A) ?> }</div>
            <div class="set-elems"><?= implode('', $elems($A)) ?></div>
        </div>
        <div class="set-card b">
            <div class="set-title">B = { <?= implode(', ', $B) ?> }</div>
            <div class="set-elems"><?= implode('', $elems($B)) ?></div>
        </div>
    </div>

    <!-- Diagrama de Venn -->
    <div class="venn-wrap">
        <div class="venn-titulo">Diagrama de Venn</div>
        <?php
            // Clasificar elementos para el SVG
            $soloA = $dAB;
            $soloB = $dBA;
            $inter = $I;

            $txtA    = count($soloA) <= 6 ? implode(', ', $soloA) : implode(', ', array_slice($soloA,0,5)).'…';
            $txtB    = count($soloB) <= 6 ? implode(', ', $soloB) : implode(', ', array_slice($soloB,0,5)).'…';
            $txtAB   = count($inter) <= 4  ? implode(', ', $inter) : implode(', ', array_slice($inter,0,3)).'…';
            $hayAB   = count($inter) > 0;
        ?>
        <svg class="venn" viewBox="0 0 520 220" xmlns="http://www.w3.org/2000/svg">
            <!-- Fondo -->
            <rect width="520" height="220" rx="14" fill="#f9f7f3"/>

            <!-- Etiqueta universo -->
            <text x="14" y="20" font-family="DM Sans,sans-serif" font-size="11"
                  fill="#9a9080" letter-spacing="1">U</text>

            <!-- Círculo A -->
            <circle cx="195" cy="110" r="88"
                    fill="rgba(79,70,229,0.13)"
                    stroke="#4f46e5" stroke-width="2"/>

            <!-- Círculo B -->
            <circle cx="325" cy="110" r="88"
                    fill="rgba(229,70,106,0.13)"
                    stroke="#e5466a" stroke-width="2"/>

            <!-- Intersección coloreada -->
            <?php if ($hayAB): ?>
            <path d="
                M 260,35.5
                A 88,88 0 0,1 260,184.5
                A 88,88 0 0,1 260,35.5
            " fill="rgba(147,51,234,0.18)" />
            <?php endif; ?>

            <!-- Label A -->
            <text x="148" y="44" font-family="Fraunces,serif"
                  font-size="22" font-weight="700" fill="#4f46e5">A</text>

            <!-- Label B -->
            <text x="348" y="44" font-family="Fraunces,serif"
                  font-size="22" font-weight="700" fill="#e5466a">B</text>

            <!-- Texto solo A -->
            <foreignObject x="60" y="75" width="130" height="80">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     style="font-family:'JetBrains Mono',monospace;font-size:11px;
                            color:#3730a3;text-align:center;line-height:1.5;word-break:break-all;">
                    <?= $txtA !== '' ? $txtA : '∅' ?>
                </div>
            </foreignObject>

            <!-- Texto intersección -->
            <?php if ($hayAB): ?>
            <foreignObject x="210" y="75" width="100" height="80">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     style="font-family:'JetBrains Mono',monospace;font-size:11px;
                            color:#7e22ce;text-align:center;line-height:1.5;word-break:break-all;">
                    <?= $txtAB ?>
                </div>
            </foreignObject>
            <?php endif; ?>

            <!-- Texto solo B -->
            <foreignObject x="330" y="75" width="130" height="80">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     style="font-family:'JetBrains Mono',monospace;font-size:11px;
                            color:#9f1239;text-align:center;line-height:1.5;word-break:break-all;">
                    <?= $txtB !== '' ? $txtB : '∅' ?>
                </div>
            </foreignObject>

            <!-- Leyenda inferior -->
            <circle cx="30" cy="200" r="6" fill="rgba(79,70,229,0.4)" stroke="#4f46e5" stroke-width="1.5"/>
            <text x="42" y="204" font-family="DM Sans,sans-serif" font-size="11" fill="#6b7280">Solo A</text>

            <circle cx="120" cy="200" r="6" fill="rgba(147,51,234,0.4)" stroke="#9333ea" stroke-width="1.5"/>
            <text x="132" y="204" font-family="DM Sans,sans-serif" font-size="11" fill="#6b7280">A ∩ B</text>

            <circle cx="200" cy="200" r="6" fill="rgba(229,70,106,0.4)" stroke="#e5466a" stroke-width="1.5"/>
            <text x="212" y="204" font-family="DM Sans,sans-serif" font-size="11" fill="#6b7280">Solo B</text>
        </svg>
    </div>

    <!-- Operaciones -->
    <div class="ops-grid">

        <!-- Unión -->
        <div class="op-card union">
            <div class="op-header">
                <span class="op-symbol">A ∪ B</span>
                <span class="op-name">Unión</span>
            </div>
            <div class="op-conjunto"><?= $render($U) ?></div>
            <div class="op-count">|A ∪ B| = <?= count($U) ?> elementos</div>
        </div>

        <!-- Intersección -->
        <div class="op-card interseccion">
            <div class="op-header">
                <span class="op-symbol">A ∩ B</span>
                <span class="op-name">Intersección</span>
            </div>
            <div class="op-conjunto"><?= $render($I) ?></div>
            <div class="op-count">|A ∩ B| = <?= count($I) ?> elementos</div>
        </div>

        <!-- Diferencia A - B -->
        <div class="op-card difAB">
            <div class="op-header">
                <span class="op-symbol">A − B</span>
                <span class="op-name">Diferencia A−B</span>
            </div>
            <div class="op-conjunto"><?= $render($dAB) ?></div>
            <div class="op-count">|A − B| = <?= count($dAB) ?> elementos</div>
        </div>

        <!-- Diferencia B - A -->
        <div class="op-card difBA">
            <div class="op-header">
                <span class="op-symbol">B − A</span>
                <span class="op-name">Diferencia B−A</span>
            </div>
            <div class="op-conjunto"><?= $render($dBA) ?></div>
            <div class="op-count">|B − A| = <?= count($dBA) ?> elementos</div>
        </div>

    </div>

    <?php endif; ?>

    <div class="mvc-footer">
        <span class="mvc-pill">📦 Model → ConjuntoModel.php</span>
        <span class="mvc-pill">🎨 View → index.php</span>
        <span class="mvc-pill">⚙ Controller → ConjuntoController.php</span>
    </div>

</div>

<script>
function usar(a, b) {
    document.querySelectorAll('textarea')[0].value = a;
    document.querySelectorAll('textarea')[1].value = b;
}
</script>
</body>
</html>
