<?php

class EstadisticaModel {

    /**
     * Calcula el promedio (media aritmética) de un array de números.
     */
    public function promedio(array $numeros): float {
        return array_sum($numeros) / count($numeros);
    }

    /**
     * Calcula la mediana de un array de números.
     * - Si la cantidad es impar: el valor central.
     * - Si es par: promedio de los dos centrales.
     */
    public function mediana(array $numeros): float {
        sort($numeros);
        $total = count($numeros);
        $mitad = intdiv($total, 2);

        if ($total % 2 === 1) {
            return (float) $numeros[$mitad];
        }

        return ($numeros[$mitad - 1] + $numeros[$mitad]) / 2.0;
    }

    /**
     * Calcula la moda de un array de números.
     * Puede haber una o varias modas (multimodal), o ninguna si todos aparecen igual.
     * Retorna un array con: modas[], frecuencias[], y el array ordenado por frecuencia.
     */
    public function moda(array $numeros): array {
        $frecuencias = array_count_values(
            array_map(fn($n) => (string) $n, $numeros)
        );

        arsort($frecuencias);
        $maxFrecuencia = reset($frecuencias);

        // Si todos tienen la misma frecuencia = sin moda
        $minFrecuencia = min($frecuencias);
        $sinModa = ($maxFrecuencia === $minFrecuencia && $maxFrecuencia === 1);

        $modas = [];
        if (!$sinModa) {
            foreach ($frecuencias as $valor => $freq) {
                if ($freq === $maxFrecuencia) {
                    $modas[] = (float) $valor;
                }
            }
        }

        return [
            'modas'        => $modas,
            'frecuencias'  => $frecuencias,
            'maxFrecuencia'=> $maxFrecuencia,
            'sinModa'      => $sinModa,
        ];
    }

    /**
     * Devuelve el array ordenado (para visualización de mediana).
     */
    public function ordenar(array $numeros): array {
        $copia = $numeros;
        sort($copia);
        return $copia;
    }
}
