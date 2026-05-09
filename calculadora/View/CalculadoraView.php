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
<style>
.op-grid {
  display: grid;
  grid-template-columns: repeat(5,1fr);
  gap: .5rem;
}
.op-btn {
  background: var(--bg);
  border: 1px solid var(--border);
  border-radius: 8px;
  color: var(--text);
  font-family: var(--font-h);
  font-size: 1.2rem;
  font-weight: 700;
  padding: .7em;
  cursor: pointer;
  transition: all .2s;
  text-align: center;
}
.op-btn:hover  { border-color: var(--accent); color: var(--accent); }
.op-btn.active { background: rgba(79,255,176,.12); border-color: var(--accent); color: var(--accent); }

.hist-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: .6rem 0;
  border-bottom: 1px solid var(--border);
  font-size: .82rem;
  gap: .5rem;
}
.hist-item:last-child { border-bottom: none; }
.hist-expr { color: var(--muted); }
.hist-res  { color: var(--accent); font-family:var(--font-h); font-weight:700; font-size:1rem; }
.hist-hora { font-size:.68rem; color:var(--muted); white-space:nowrap; }
</style>
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
      <div style="display:grid;grid-template-columns:1fr auto 1fr;gap:.75rem;align-items:end">
        <div class="form-group" style="margin:0">
          <label for="a">Número A</label>
          <input type="text" id="a" name="a" placeholder="ej. 125" value="<?= $d['a'] ?>">
        </div>
        <span id="op-display" style="font-family:var(--font-h);font-size:1.6rem;color:var(--accent);padding-bottom:.6rem;text-align:center">
          <?= $ops[$d['op']] ?? '+' ?>
        </span>
        <div class="form-group" style="margin:0">
          <label for="b">Número B</label>
          <input type="text" id="b" name="b" placeholder="ej. 4" value="<?= $d['b'] ?>">
        </div>
      </div>

      <button class="btn" type="submit" name="calcular" value="1" style="width:100%;justify-content:center;margin-top:.5rem">
        = Calcular
      </button>
    </form>

    <?php if ($d['resultado'] !== null):
      $model = new CalculadoraModel();
    ?>
    <div class="result animate">
      <p class="result-label">Resultado</p>
      <p class="result-value"><?= htmlspecialchars($model->formatear($d['resultado'])) ?></p>
      <p style="margin-top:.5rem;font-size:.78rem;color:var(--muted)">
        <?= htmlspecialchars($d['a']) ?>
        <span style="color:var(--accent)"><?= htmlspecialchars($ops[$d['op']]??$d['op']) ?></span>
        <?= htmlspecialchars($d['b']) ?>
        = <?= htmlspecialchars($model->formatear($d['resultado'])) ?>
      </p>
    </div>
    <?php endif; ?>
  </div>

  <!-- Historial -->
  <div class="card" style="margin-top:1.5rem">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
      <p style="font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted)">
        Historial (<?= count($d['historial']) ?>)
      </p>
      <?php if (!empty($d['historial'])): ?>
      <form method="POST" style="margin:0">
        <button class="btn btn-danger" type="submit" name="borrar_historial" value="1"
                style="font-size:.75rem;padding:.45em 1em">
          Borrar historial
        </button>
      </form>
      <?php endif; ?>
    </div>

    <?php if (empty($d['historial'])): ?>
      <p style="font-size:.8rem;color:var(--muted);text-align:center;padding:1.5rem 0">
        Aún no hay operaciones en el historial.
      </p>
    <?php else: ?>
      <?php foreach($d['historial'] as $h): ?>
      <div class="hist-item">
        <span class="hist-expr">
          <?= htmlspecialchars($h['a']) ?>
          <span style="color:var(--accent2)"><?= htmlspecialchars($h['simbolo']) ?></span>
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
