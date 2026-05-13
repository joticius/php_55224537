<?php
function renderConjuntos(array $d): void {
    $r   = $d['resultado'];
    $fmt = fn(array $arr) => empty($arr) ? '∅' : '{' . implode(', ', $arr) . '}';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Conjuntos · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">04</div>
    <h1 class="page-title">Teoría de Conjuntos</h1>
    <p class="page-desc">Ingresa dos conjuntos A y B de enteros (separados por comas). Se calculará unión, intersección y diferencias, con diagrama de Venn.</p>
  </div>

  <div class="card animate">
    <form method="POST">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>
      <div class="grid-2">
        <div class="form-group no-margin">
          <label for="a">Conjunto A</label>
          <input type="text" id="a" name="a" placeholder="ej. 1, 2, 3, 4" value="<?= $d['a'] ?>">
        </div>
        <div class="form-group no-margin">
          <label for="b">Conjunto B</label>
          <input type="text" id="b" name="b" placeholder="ej. 3, 4, 5, 6" value="<?= $d['b'] ?>">
        </div>
      </div>
      <button class="btn mt-1-25" type="submit">Calcular →</button>
    </form>

    <?php if ($r): ?>

    <!-- Diagrama Venn SVG -->
    <?php
    $aOnly  = $d['setA'] ? array_diff($d['setA'], $d['setB']) : [];
    $inter  = $r['interseccion'];
    $bOnly  = $d['setB'] ? array_diff($d['setB'], $d['setA']) : [];
    ?>
    <svg viewBox="0 0 520 200" xmlns="http://www.w3.org/2000/svg" class="svg-box mt-1-5">
      <defs>
        <clipPath id="clipA"><circle cx="185" cy="100" r="95"/></clipPath>
        <clipPath id="clipB"><circle cx="335" cy="100" r="95"/></clipPath>
      </defs>
      <!-- Círculo A -->
      <circle cx="185" cy="100" r="95" fill="rgba(79,255,176,.1)" stroke="#4fffb0" stroke-width="1.5"/>
      <!-- Círculo B -->
      <circle cx="335" cy="100" r="95" fill="rgba(108,99,255,.1)" stroke="#6c63ff" stroke-width="1.5"/>
      <!-- Intersección highlight -->
      <circle cx="335" cy="100" r="95" fill="rgba(255,255,255,.04)" clip-path="url(#clipA)"/>

      <!-- Labels A/B -->
      <text x="130" y="40" font-family="Syne,sans-serif" font-weight="800" font-size="18" fill="#4fffb0">A</text>
      <text x="370" y="40" font-family="Syne,sans-serif" font-weight="800" font-size="18" fill="#6c63ff">B</text>

      <!-- Elementos solo A -->
      <?php $ay=85; $ax=120; foreach(array_slice(array_values($aOnly),0,6) as $i=>$v): ?>
      <text x="<?=$ax+($i%2)*50?>" y="<?=$ay+floor($i/2)*22?>"
            font-family="JetBrains Mono,monospace" font-size="12" fill="#4fffb0" text-anchor="middle"><?=$v?></text>
      <?php endforeach; ?>

      <!-- Intersección -->
      <?php $iy=85; foreach(array_slice($inter,0,4) as $i=>$v): ?>
      <text x="260" y="<?=$iy+$i*22?>"
            font-family="JetBrains Mono,monospace" font-size="12" fill="#e8eaf0" text-anchor="middle"><?=$v?></text>
      <?php endforeach; ?>

      <!-- Elementos solo B -->
      <?php $by=85; $bx=390; foreach(array_slice(array_values($bOnly),0,6) as $i=>$v): ?>
      <text x="<?=$bx-($i%2)*50?>" y="<?=$by+floor($i/2)*22?>"
            font-family="JetBrains Mono,monospace" font-size="12" fill="#6c63ff" text-anchor="middle"><?=$v?></text>
      <?php endforeach; ?>
    </svg>

    <!-- Resultados -->
    <div class="result-grid-2">
      <?php
      $ops = [
        ['A ∪ B (Unión)',            'badge-accent', $r['union']],
        ['A ∩ B (Intersección)',     'badge-accent2', $r['interseccion']],
        ['A − B (Diferencia)',       'badge-warning', $r['difAB']],
        ['B − A (Diferencia)',       'badge-danger', $r['difBA']],
      ];
      foreach($ops as [$label,$badgeClass,$set]): ?>
      <div class="card-panel">
        <p class="panel-label <?= $badgeClass ?>"><?= $label ?></p>
        <p class="panel-text"><?= $fmt($set) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
