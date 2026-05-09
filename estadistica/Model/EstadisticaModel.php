<?php
class EstadisticaModel {
    public function calcular(array $nums): array {
        $n = count($nums);
        sort($nums);

        // Promedio (media aritmética)
        $promedio = array_sum($nums) / $n;

        // Mediana
        if ($n % 2 === 0) {
            $mediana = ($nums[$n/2 - 1] + $nums[$n/2]) / 2;
        } else {
            $mediana = $nums[(int)($n/2)];
        }

        // Moda y tabla de frecuencias
        $freq = array_count_values(array_map(fn($x) => (string)$x, $nums));
        arsort($freq);
        $maxFreq = max($freq);
        $moda = array_keys(array_filter($freq, fn($f) => $f === $maxFreq));
        $moda = array_map('floatval', $moda);

        return [
            'n'        => $n,
            'nums'     => $nums,
            'promedio' => $promedio,
            'mediana'  => $mediana,
            'moda'     => $moda,
            'freq'     => $freq,
            'max_freq' => $maxFreq,
        ];
    }

    public function parsearEntrada(string $entrada): array {
        // acepta comas, punto y coma, espacios
        $partes = preg_split('/[\s,;]+/', trim($entrada), -1, PREG_SPLIT_NO_EMPTY);
        $nums   = [];
        foreach ($partes as $p) {
            if (!is_numeric($p)) return [];
            $nums[] = (float)$p;
        }
        return $nums;
    }
}
