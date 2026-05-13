<?php
function renderFibonacci(array $d): void { ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Fibonacci &amp; Factorial · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">02</div>
    <h1 class="page-title">Fibonacci &amp; Factorial</h1>
    <p class="page-desc">Ingresa un número y selecciona la operación. Para Fibonacci se genera la serie completa; para Factorial el resultado del producto acumulado.</p>
  </div>

  <div class="card animate">
    <form method="POST">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>

      <div class="form-group">
        <label>Operación</label>
        <div class="radio-group">
          <label><input type="radio" name="op" value="fibonacci"
            <?= $d['op']==='fibonacci'?'checked':'' ?>> Sucesión de Fibonacci</label>
          <label><input type="radio" name="op" value="factorial"
            <?= $d['op']==='factorial'?'checked':'' ?>> Factorial (n!)</label>
        </div>
      </div>

      <div class="form-group">
        <label for="n">Número (n)</label>
        <input type="number" id="n" name="n" min="0" value="<?= $d['n'] ?>" placeholder="ej. 10" autofocus>
      </div>

      <button class="btn" type="submit">Calcular →</button>
    </form>

    <?php if ($d['serie'] !== null): ?>
    <div class="result animate">
      <p class="result-label">Serie de Fibonacci (<?= count($d['serie']) ?> términos)</p>
      <div class="chips mt-0-5">
        <?php foreach($d['serie'] as $v): ?>
          <span class="chip"><?= $v ?></span>
        <?php endforeach; ?>
      </div>
    </div>
    <?php if (!empty($d['pasos'])): ?>
    <details class="mt-1">
      <summary class="summary-toggle">Ver paso a paso</summary>
      <div class="details-body">
        <?php foreach($d['pasos'] as $p): ?>
          <code class="code-inline"><?= htmlspecialchars($p) ?></code>
        <?php endforeach; ?>
      </div>
    </details>
    <?php endif; ?>
    <?php endif; ?>

    <?php if ($d['resultado'] !== null): ?>
    <div class="result animate">
      <p class="result-label">Factorial de <?= $d['n'] ?></p>
      <p class="result-value result-value-sm"><?= $d['resultado'] ?></p>
    </div>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
