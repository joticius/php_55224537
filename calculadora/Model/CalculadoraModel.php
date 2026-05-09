<?php
class CalculadoraModel {
    public function calcular(float $a, float $b, string $op): array {
        $resultado = null;
        $error     = null;
        switch ($op) {
            case '+': $resultado = $a + $b; break;
            case '-': $resultado = $a - $b; break;
            case '*': $resultado = $a * $b; break;
            case '/':
                if ($b == 0) $error = 'División por cero no permitida.';
                else $resultado = $a / $b;
                break;
            case '%':
                if ($b == 0) $error = 'División por cero no permitida.';
                else $resultado = ($a * $b) / 100;
                break;
            default: $error = 'Operación no válida.';
        }
        return compact('resultado','error');
    }

    public function formatear(float $n): string {
        // evitar notación científica y trailing zeros
        if (floor($n) == $n && abs($n) < 1e15) return number_format($n, 0, '.', '');
        return rtrim(rtrim(number_format($n, 10, '.', ''), '0'), '.');
    }

    public function simboloOp(string $op): string {
        return match($op) { '+'=>'+', '-'=>'−', '*'=>'×', '/'=>'÷', '%'=>'%', default=>$op };
    }
}
