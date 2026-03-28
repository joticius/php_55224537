<?php

class MatematicaModel {

    /**
     * Genera la serie de Fibonacci hasta el término n.
     * Retorna un array con todos los números de la serie.
     */
    public function fibonacci(int $n): array {
        if ($n <= 0) return [];
        if ($n === 1) return [0];

        $serie = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $serie[] = $serie[$i - 1] + $serie[$i - 2];
        }
        return $serie;
    }

    /**
     * Calcula el factorial de n y retorna cada paso intermedio.
     * Retorna un array con [número, resultado_parcial] para mostrar la serie.
     */
    public function factorial(int $n): array {
        if ($n < 0) return [];
        if ($n === 0) return [['num' => 0, 'resultado' => 1]];

        $pasos = [];
        $acumulado = 1;
        for ($i = 1; $i <= $n; $i++) {
            $acumulado *= $i;
            $pasos[] = ['num' => $i, 'resultado' => $acumulado];
        }
        return $pasos;
    }
}
