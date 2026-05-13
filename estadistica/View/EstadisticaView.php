<?php
function renderEstadistica(array $d): void {
    $r = $d['resultado'];
    $fmt = fn($v) => (floor($v)==$v) ? number_format($v,0) : number_format($v,4,'.','');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Estadística · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">03</div>
    <h1 class="page-title">Estadística</h1>
    <p class="page-desc">Ingresa una serie de números reales separados por comas o espacios. Se calculará el promedio (media aritmética), la mediana y la moda con su tabla de frecuencias.</p>
  </div>

  <div class="card animate">
    <form method="POST">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>
      <div class="form-group">
        <label for="numeros">Serie de números</label>
        <input type="text" id="numeros" name="numeros"
               placeholder="ej. 2, 4, 4, 4, 5, 5, 7, 9"
               value="<?= $d['entrada'] ?>" autofocus>
      </div>
      <button class="btn" type="submit">Calcular →</button>
    </form>

    <?php if ($r): ?>

    <div class="result-grid-3">
      <?php
      $stats = [
        ['Promedio',  $fmt($r['promedio'])],
        ['Mediana',   $fmt($r['mediana'])],
        ['Moda',      implode(', ', array_map($fmt, $r['moda']))],
      ];
      foreach ($stats as [$label,$val]): ?>
      <div class="result animate m-0">
        <p class="result-label"><?= $label ?></p>
        <p class="result-value result-value-lg"><?= $val ?></p>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="mt-1-5">
      <p class="small-label">
        Tabla de frecuencias (n = <?= $r['n'] ?>)
      </p>
      <table>
        <thead><tr><th>Valor</th><th>Frecuencia</th><th>% relativo</th><th></th></tr></thead>
        <tbody>
        <?php foreach($r['freq'] as $val=>$f):
          $pct = round($f/$r['n']*100,1);
          $isModa = ($f === $r['max_freq']);
        ?>
        <tr>
          <td><?= $val ?></td>
          <td><?= $f ?></td>
          <td><?= $pct ?>%</td>
          <td><?php if($isModa): ?>
            <span class="panel-label badge-accent">moda</span>
          <?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
