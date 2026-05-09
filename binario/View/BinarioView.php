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
<style>
.led-row { display:flex; flex-wrap:wrap; gap:.5rem; margin:.8rem 0; }
.led {
  width:52px; height:52px;
  border-radius:8px;
  display:flex; flex-direction:column;
  align-items:center; justify-content:center;
  font-family:var(--font-h); font-weight:800; font-size:1.4rem;
  border: 2px solid;
  transition: all .3s;
}
.led-on  { background:rgba(79,255,176,.15); border-color:#4fffb0; color:#4fffb0; box-shadow:0 0 18px rgba(79,255,176,.35); }
.led-off { background:rgba(30,33,48,.5); border-color:var(--border); color:var(--muted); }
.led small { font-size:.52rem; font-family:var(--font-m); font-weight:300; opacity:.6; margin-top:2px; }
</style>
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
      <p style="margin-top:.5rem;font-size:.78rem;color:var(--muted)">
        <?= $r['decimal'] ?><sub>10</sub> = <?= htmlspecialchars($r['binario']) ?><sub>2</sub>
      </p>
    </div>

    <!-- LED display -->
    <div style="margin-top:1.25rem">
      <p style="font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem">Visualización LED</p>
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
    <details style="margin-top:1rem">
      <summary style="cursor:pointer;font-size:.78rem;color:var(--muted);letter-spacing:.05em">
        Ver proceso de divisiones
      </summary>
      <div style="margin-top:.8rem">
        <table>
          <thead><tr><th>Dividendo</th><th>Cociente</th><th>Residuo (bit)</th></tr></thead>
          <tbody>
          <?php foreach($r['pasos'] as $p): ?>
          <tr>
            <td><?= $p['dividendo'] ?></td>
            <td><?= $p['cociente'] ?></td>
            <td style="color:<?=$p['residuo']?'#4fffb0':'var(--muted)'?>;font-weight:600"><?= $p['residuo'] ?></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <p style="font-size:.72rem;color:var(--muted);margin-top:.6rem">← Los residuos leídos de abajo hacia arriba forman el binario.</p>
      </div>
    </details>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
