<?php
function renderAcronimo(array $datos): void { ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Acrónimos · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">01</div>
    <h1 class="page-title">Acrónimos</h1>
    <p class="page-desc">Convierte una frase larga en su acrónimo. Los guiones y espacios funcionan como separadores de palabras. Los signos de puntuación se eliminan automáticamente.</p>
  </div>

  <div class="card animate">
    <form method="POST" action="">
      <?php if ($datos['error']): ?>
        <div class="error"><?= $datos['error'] ?></div>
      <?php endif; ?>

      <div class="form-group">
        <label for="frase">Frase o nombre largo</label>
        <input type="text" id="frase" name="frase"
               placeholder="ej. As Soon As Possible"
               value="<?= $datos['frase'] ?>" autofocus>
      </div>

      <div class="flex-gap">
        <button class="btn" type="submit">Convertir →</button>
        <?php if ($datos['acronimo']): ?>
        <span class="text-muted">Ejemplos:
          <a href="?frase=As+Soon+As+Possible" class="link-accent">ASAP</a> ·
          <a href="?frase=Liquid-crystal+display" class="link-accent">LCD</a>
        </span>
        <?php endif; ?>
      </div>
    </form>

    <?php if ($datos['acronimo'] !== null): ?>
    <div class="result animate">
      <p class="result-label">Acrónimo</p>
      <p class="result-value"><?= htmlspecialchars($datos['acronimo']) ?></p>
      <p class="text-muted mt-0-5">
        Frase original: <span class="badge-text"><?= $datos['frase'] ?></span>
      </p>
    </div>
    <?php endif; ?>
  </div>

  <div class="card card-border">
    <p class="section-title">Ejemplos clásicos</p>
    <?php
    $ejemplos = [
      'As Soon As Possible'       => 'ASAP',
      'Portable Network Graphics' => 'PNG',
      'Liquid-crystal display'    => 'LCD',
      "Thank George It's Friday!" => 'TGIF',
    ];
    foreach ($ejemplos as $f => $a): ?>
    <div class="row-fs">
      <span class="text-muted"><?= htmlspecialchars($f) ?></span>
      <span class="accent-strong"><?= $a ?></span>
    </div>
    <?php endforeach; ?>
  </div>

</div></body>
</html>
<?php }
