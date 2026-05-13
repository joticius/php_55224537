<?php
function renderBinario(array $d): void {
    $r = $d['resultado'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Decimal → Binario · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">05</div>
    <h1 class="page-title">Decimal → Binario</h1>
    <p class="page-desc">Ingresa un número entero y se convertirá a su representación binaria mostrando el proceso de divisiones sucesivas y una visualización tipo LED.</p>
  </div>

  <div class="card animate">
    <form method="POST">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>
      <div class="form-group">
        <label for="n">Número decimal</label>
        <input type="number" id="n" name="n" placeholder="ej. 42"
               value="<?= $d['n'] ?>" autofocus>
      </div>
      <button class="btn" type="submit">Convertir →</button>
    </form>

    <?php if ($r): ?>
    <div class="result animate">
      <p class="result-label">Resultado en binario</p>
      <p class="result-value"><?= htmlspecialchars($r['binario']) ?></p>
      <p class="text-muted mt-0-5">
        <?= $r['decimal'] ?><sub>10</sub> = <?= htmlspecialchars($r['binario']) ?><sub>2</sub>
      </p>
    </div>

    <!-- LED display -->
    <div class="mt-1-25">
      <p class="small-label">Visualización LED</p>
      <div class="led-row">
        <?php
        $bits = $r['bits'];
        $n = count($bits);
        foreach ($bits as $i => $bit):
          $pos = $n - 1 - $i;
          $cls = $bit === '1' ? 'led led-on' : 'led led-off';
        ?>
        <div class="<?= $cls ?>">
          <?= $bit ?>
          <small>2<sup><?= $pos ?></sup></small>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Tabla de divisiones -->
    <details class="mt-1">
      <summary class="summary-toggle">
        Ver proceso de divisiones
      </summary>
      <div class="mt-0-5">
        <table>
          <thead><tr><th>Dividendo</th><th>Cociente</th><th>Residuo (bit)</th></tr></thead>
          <tbody>
          <?php foreach($r['pasos'] as $p): ?>
          <tr>
            <td><?= $p['dividendo'] ?></td>
            <td><?= $p['cociente'] ?></td>
            <td class="<?= $p['residuo'] ? 'bit-ok' : 'text-muted' ?>"><?= $p['residuo'] ?></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <p class="text-muted mt-0-5">← Los residuos leídos de abajo hacia arriba forman el binario.</p>
      </div>
    </details>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
