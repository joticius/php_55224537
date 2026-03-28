<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="calculator">
        <h1>Calculadora</h1>
        <form method="post" action="">
            <input type="number" step="any" name="num1" placeholder="Número 1" required>
            <select name="operation" required>
                <option value="+">Suma (+)</option>
                <option value="-">Resta (-)</option>
                <option value="*">Multiplicación (*)</option>
                <option value="/">División (/)</option>
                <option value="%">Porcentaje (%)</option>
            </select>
            <input type="number" step="any" name="num2" placeholder="Número 2" required>
            <button type="submit" name="calculate">Calcular</button>
        </form>
        <?php if ($data['result'] !== null): ?>
            <p class="result">Resultado: <?php echo htmlspecialchars($data['result']); ?></p>
        <?php endif; ?>
        <h2>Historial</h2>
        <ul class="history">
            <?php foreach ($data['history'] as $entry): ?>
                <li><?php echo htmlspecialchars($entry); ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="">
            <button type="submit" name="clear_history">Borrar Historial</button>
        </form>
    </div>
</body>
</html>