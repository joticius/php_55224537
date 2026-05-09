<?php
$apps = [
  ['01','Acrónimos',         'Convierte frases largas en su acrónimo. Guiones y espacios son separadores.',  'PNG → Portable Network Graphics','🔤','acronimo/index.php'],
  ['02','Fibonacci & Factorial','Calcula la sucesión de Fibonacci o el factorial de un número dado.',        'n=7 → 0 1 1 2 3 5 8 / 5040',   '∑', 'fibonacci/index.php'],
  ['03','Estadística',        'Promedio, mediana y moda de una serie de números reales.',                    '2 4 4 5 5 7 → media 4.5',       '📊','estadistica/index.php'],
  ['04','Teoría de Conjuntos','Unión, intersección y diferencia A-B / B-A con diagrama Venn SVG.',           'A={1,2,3} B={3,4} → A∩B={3}',  '⊂', 'conjuntos/index.php'],
  ['05','Decimal → Binario',  'Convierte un entero a binario con visualización LED de bits.',                '42 → 101010',                   '⚡','binario/index.php'],
  ['06','Árbol Binario',      'Reconstruye el árbol a partir de preorden, inorden y/o postorden.',           'Pre + In → árbol SVG',          '🌳','arbol/index.php'],
  ['07','Calculadora',        'Operaciones básicas (+ - × ÷ %) con historial persistente en sesión.',        '125 × 4 = 500',                 '🧮','calculadora/index.php'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Taller PHP — Universidad de Boyacá</title>
<link rel="stylesheet" href="shared.css">
<style>
  body { padding: 0 1rem 5rem; }

  header {
    text-align: center;
    padding: 5rem 1rem 3rem;
    max-width: 700px;
    margin: 0 auto;
  }
  .badge {
    display: inline-block;
    font-size: .7rem;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--accent);
    border: 1px solid var(--accent);
    padding: .35em 1.1em;
    border-radius: 999px;
    margin-bottom: 1.8rem;
    animation: fadeIn .5s ease both;
  }
  h1 {
    font-family: var(--font-h);
    font-weight: 800;
    font-size: clamp(2.4rem,6vw,4.5rem);
    line-height: 1.05;
    letter-spacing: -.03em;
    animation: fadeIn .5s .1s ease both;
  }
  h1 em {
    font-style: normal;
    color: transparent;
    -webkit-text-stroke: 1.5px var(--muted);
  }
  .sub {
    margin-top: 1rem;
    font-size: .8rem;
    color: var(--muted);
    letter-spacing: .1em;
    animation: fadeIn .5s .2s ease both;
  }
  .divider {
    width: 50px; height: 3px;
    background: linear-gradient(90deg,var(--accent),var(--accent2));
    border-radius: 2px;
    margin: 2.5rem auto;
    animation: fadeIn .5s .25s ease both;
  }

  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(300px,1fr));
    gap: 1.4rem;
    max-width: 1100px;
    margin: 0 auto;
  }

  .app-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 2rem;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    gap: .9rem;
    transition: transform .25s, border-color .25s, box-shadow .25s;
    animation: fadeIn .5s ease both;
  }
  .app-card:hover {
    transform: translateY(-5px);
    border-color: var(--accent);
    box-shadow: 0 0 40px rgba(79,255,176,.1), 0 20px 50px rgba(0,0,0,.4);
  }
  .card-top { display:flex; justify-content:space-between; align-items:flex-start; }
  .num {
    font-family: var(--font-h);
    font-weight: 800;
    font-size: 3.5rem;
    line-height: 1;
    color: transparent;
    -webkit-text-stroke: 1.5px var(--border);
    transition: -webkit-text-stroke-color .25s;
  }
  .app-card:hover .num { -webkit-text-stroke-color: var(--accent); }
  .ico { font-size: 2rem; filter: grayscale(1); transition: filter .25s; }
  .app-card:hover .ico { filter: none; }

  .app-title { font-family:var(--font-h); font-weight:700; font-size:1.2rem; }
  .app-desc  { font-size:.77rem; color:var(--muted); line-height:1.7; flex:1; }
  .app-ex {
    font-size:.72rem;
    color: var(--accent);
    background: rgba(79,255,176,.06);
    border: 1px solid rgba(79,255,176,.15);
    padding: .45em .85em;
    border-radius: 7px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .arr { font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:.5em; transition: color .2s, gap .2s; }
  .app-card:hover .arr { color:var(--accent); gap:.9em; }

  footer {
    text-align:center;
    padding:2.5rem 1rem;
    font-size:.72rem;
    color:var(--muted);
    letter-spacing:.08em;
  }
  footer b { color:var(--accent); font-weight:400; }
</style>
</head>
<body>

<header>
  <div class="badge">Universidad de Boyacá · Taller PHP</div>
  <h1>Aplicaciones<br><em>Web</em> con PHP</h1>
  <p class="sub">POO &nbsp;·&nbsp; Arquitectura MVC &nbsp;·&nbsp; HTML &amp; CSS</p>
  <div class="divider"></div>
</header>

<nav class="grid">
<?php foreach($apps as $i=>[$num,$tit,$desc,$ej,$ico,$url]): ?>
<a href="<?=htmlspecialchars($url)?>" class="app-card" style="animation-delay:<?=.3+$i*.07?>s">
  <div class="card-top">
    <span class="num"><?=$num?></span>
    <span class="ico"><?=$ico?></span>
  </div>
  <p class="app-title"><?=htmlspecialchars($tit)?></p>
  <p class="app-desc"><?=htmlspecialchars($desc)?></p>
  <p class="app-ex"><?=htmlspecialchars($ej)?></p>
  <p class="arr">Abrir aplicación <span>→</span></p>
</a>
<?php endforeach; ?>
</nav>

<footer><b>MVC</b> · PHP · <?=date('Y')?> · Universidad de Boyacá</footer>
</body>
</html>
