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
</head>
<body class="home">

<header>
  <div class="badge">Universidad de Boyacá · Taller PHP</div>
  <h1>Aplicaciones<br><em>Web</em> con PHP</h1>
  <p class="sub">POO &nbsp;·&nbsp; Arquitectura MVC &nbsp;·&nbsp; HTML &amp; CSS</p>
  <div class="divider"></div>
</header>

<nav class="grid">
<?php foreach($apps as $i=>[$num,$tit,$desc,$ej,$ico,$url]): ?>
<a href="<?=htmlspecialchars($url)?>" class="app-card delay-<?= $i + 1 ?>">
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
