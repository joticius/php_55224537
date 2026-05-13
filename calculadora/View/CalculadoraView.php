<?php
function renderCalculadora(array $d): void {
    $ops = ['+'=>'+', '-'=>'−', '*'=>'×', '/'=>'÷', '%'=>'%'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Calculadora · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">07</div>
    <h1 class="page-title">Calculadora</h1>
    <p class="page-desc">Realiza operaciones básicas con enteros o decimales. El historial se guarda durante tu sesión y puedes borrarlo cuando quieras.</p>
  </div>

  <div class="card animate">
    <form method="POST" id="calcForm">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>

      <!-- Operación -->
      <div class="form-group">
        <label>Operación</label>
        <div class="op-grid">
          <?php foreach($ops as $val=>$sym): ?>
          <button type="button"
            class="op-btn <?= $d['op']===$val?'active':'' ?>"
            onclick="selectOp('<?=$val?>')">
            <?=$sym?>
          </button>
          <?php endforeach; ?>
        </div>
        <input type="hidden" name="op" id="op" value="<?= htmlspecialchars($d['op']) ?>">
      </div>

      <!-- Números -->
      <div class="grid-2-1">
        <div class="form-group no-margin">
          <label for="a">Número A</label>
          <input type="text" id="a" name="a" placeholder="ej. 125" value="<?= $d['a'] ?>">
        </div>
        <span id="op-display" class="op-display">
          <?= $ops[$d['op']] ?? '+' ?>
        </span>
        <div class="form-group no-margin">
          <label for="b">Número B</label>
          <input type="text" id="b" name="b" placeholder="ej. 4" value="<?= $d['b'] ?>">
        </div>
      </div>

      <button class="btn btn-full mt-0-5" type="submit" name="calcular" value="1">
        = Calcular
      </button>
    </form>

    <?php if ($d['resultado'] !== null):
      $model = new CalculadoraModel();
    ?>
    <div class="result animate">
      <p class="result-label">Resultado</p>
      <p class="result-value"><?= htmlspecialchars($model->formatear($d['resultado'])) ?></p>
      <p class="text-muted mt-0-5">
        <?= htmlspecialchars($d['a']) ?>
        <span class="text-accent"><?= htmlspecialchars($ops[$d['op']]??$d['op']) ?></span>
        <?= htmlspecialchars($d['b']) ?>
        = <?= htmlspecialchars($model->formatear($d['resultado'])) ?>
      </p>
    </div>
    <?php endif; ?>
  </div>

  <!-- Historial -->
  <div class="card mt-1-5">
    <div class="flex-row-between mb-1">
      <p class="small-label text-muted">
        Historial (<?= count($d['historial']) ?>)
      </p>
      <?php if (!empty($d['historial'])): ?>
      <form method="POST">
        <button class="btn btn-danger" type="submit" name="borrar_historial" value="1">
          Borrar historial
        </button>
      </form>
      <?php endif; ?>
    </div>

    <?php if (empty($d['historial'])): ?>
      <p class="info-note">
        Aún no hay operaciones en el historial.
      </p>
    <?php else: ?>
      <?php foreach($d['historial'] as $h): ?>
      <div class="hist-item">
        <span class="hist-expr">
          <?= htmlspecialchars($h['a']) ?>
          <span class="text-accent2"><?= htmlspecialchars($h['simbolo']) ?></span>
          <?= htmlspecialchars($h['b']) ?>
          =
        </span>
        <span class="hist-res"><?= htmlspecialchars($h['resultado']) ?></span>
        <span class="hist-hora"><?= $h['hora'] ?></span>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>

<script>
function selectOp(val) {
  document.getElementById('op').value = val;
  const syms = {'+':'+','-':'−','*':'×','/':'÷','%':'%'};
  document.getElementById('op-display').textContent = syms[val] || val;
  document.querySelectorAll('.op-btn').forEach(b => b.classList.remove('active'));
  event.target.classList.add('active');
}
</script>
</body>
</html>
<?php }
