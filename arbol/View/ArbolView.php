<?php
function renderArbol(array $d): void {
    $layout = $d['layout'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Árbol Binario · Taller PHP</title>
<link rel="stylesheet" href="../shared.css">
</head>
<body><div class="container">

  <a href="../index.php" class="back">← Volver al menú</a>

  <div class="page-header">
    <div class="page-num">06</div>
    <h1 class="page-title">Árbol Binario</h1>
    <p class="page-desc">Ingresa al menos dos recorridos (Preorden + Inorden, o Postorden + Inorden) para reconstruir y visualizar el árbol. Usa letras o números separados por espacios o comas.</p>
  </div>

  <div class="card animate">
    <form method="POST">
      <?php if ($d['error']): ?>
        <div class="error"><?= $d['error'] ?></div>
      <?php endif; ?>
      <?php
      $fields = [
        ['pre',  'Preorden',  'ej. A B D E C'],
        ['in',   'Inorden',   'ej. D B E A C'],
        ['post', 'Postorden', 'ej. D E B C A'],
      ];
      foreach($fields as [$name,$label,$ph]): ?>
      <div class="form-group">
        <label for="<?=$name?>"><?=$label?></label>
        <input type="text" id="<?=$name?>" name="<?=$name?>"
               placeholder="<?=$ph?>" value="<?=$d[$name]?>">
      </div>
      <?php endforeach; ?>
      <button class="btn" type="submit">Construir árbol →</button>
    </form>

    <?php if ($layout && !empty($layout['nodos'])): ?>
    <?php
    $nodos   = $layout['nodos'];
    $niveles = $layout['niveles'];
    $depth   = count($niveles);
    $svgH    = max(200, $depth * 90 + 60);
    $svgW    = 600;
    $r       = 22;

    // Calcular coordenadas reales
    $coords = [];
    foreach ($nodos as $id => $n) {
        $coords[$id] = [
            'x' => (int)round($n['x'] * $svgW),
            'y' => (int)round(50 + $n['y'] * 85),
        ];
    }
    ?>
    <div style="margin-top:1.5rem">
      <p style="font-size:.7rem;letter-spacing:.12em;text-transform:uppercase;color:var(--accent);margin-bottom:.6rem">
        Árbol reconstruido · <?= htmlspecialchars($d['modo']) ?>
      </p>
      <svg viewBox="0 0 <?=$svgW?> <?=$svgH?>" xmlns="http://www.w3.org/2000/svg"
           style="width:100%;background:var(--bg);border:1px solid var(--border);border-radius:10px">

        <!-- Aristas -->
        <?php foreach($nodos as $id=>$n): if($n['padre']!==null): ?>
        <line
          x1="<?=$coords[$n['padre']]['x']?>" y1="<?=$coords[$n['padre']]['y']?>"
          x2="<?=$coords[$id]['x']?>" y2="<?=$coords[$id]['y']?>"
          stroke="var(--border)" stroke-width="1.5"/>
        <?php endif; endforeach; ?>

        <!-- Nodos -->
        <?php foreach($nodos as $id=>$n):
          $x=$coords[$id]['x']; $y=$coords[$id]['y'];
          $isRoot = ($n['padre']===null);
        ?>
        <circle cx="<?=$x?>" cy="<?=$y?>" r="<?=$r?>"
                fill="<?=$isRoot?'rgba(79,255,176,.15)':'var(--surface)'?>"
                stroke="<?=$isRoot?'#4fffb0':'#6c63ff'?>"
                stroke-width="1.5"/>
        <text x="<?=$x?>" y="<?=$y?>"
              font-family="Syne,sans-serif" font-weight="700" font-size="13"
              fill="<?=$isRoot?'#4fffb0':'#e8eaf0'?>"
              text-anchor="middle" dominant-baseline="central">
          <?= htmlspecialchars($n['valor']) ?>
        </text>
        <?php endforeach; ?>
      </svg>
    </div>

    <!-- Recorridos verificados -->
    <?php
    function preorden($nodos, $id): array {
        if ($id===null) return [];
        return array_merge([$nodos[$id]['valor']], preorden($nodos,$nodos[$id]['izq']), preorden($nodos,$nodos[$id]['der']));
    }
    function inorden($nodos, $id): array {
        if ($id===null) return [];
        return array_merge(inorden($nodos,$nodos[$id]['izq']), [$nodos[$id]['valor']], inorden($nodos,$nodos[$id]['der']));
    }
    function postorden($nodos, $id): array {
        if ($id===null) return [];
        return array_merge(postorden($nodos,$nodos[$id]['izq']), postorden($nodos,$nodos[$id]['der']), [$nodos[$id]['valor']]);
    }
    $rootId = array_key_first($nodos);
    $recPre  = implode(' → ', preorden($nodos,$rootId));
    $recIn   = implode(' → ', inorden($nodos,$rootId));
    $recPost = implode(' → ', postorden($nodos,$rootId));
    ?>
    <div style="margin-top:1rem;display:flex;flex-direction:column;gap:.5rem">
      <?php foreach([['Preorden',$recPre],['Inorden',$recIn],['Postorden',$recPost]] as [$l,$v]): ?>
      <div style="display:flex;gap:1rem;font-size:.8rem;background:var(--bg);padding:.6em 1em;border-radius:7px;border:1px solid var(--border)">
        <span style="color:var(--muted);min-width:70px"><?=$l?></span>
        <span style="color:var(--accent)"><?= htmlspecialchars($v) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

</div></body>
</html>
<?php }
