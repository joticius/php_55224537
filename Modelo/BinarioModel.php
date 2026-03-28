<?php

class BinarioModel {

    /**
     * Convierte un número entero a binario.
     * Retorna el string binario con signo para negativos (complemento visual).
     */
    public function toBinario(int $n): string {
        if ($n === 0) return '0';
        if ($n > 0)  return decbin($n);

        // Para negativos: mostramos el signo y la representación del absoluto
        return '-' . decbin(abs($n));
    }

    /**
     * Devuelve los pasos de la división sucesiva por 2.
     * Solo aplica para positivos (el proceso didáctico clásico).
     */
    public function pasos(int $n): array {
        if ($n <= 0) return [];

        $pasos = [];
        $temp  = $n;

        while ($temp > 0) {
            $pasos[] = [
                'dividendo' => $temp,
                'cociente'  => intdiv($temp, 2),
                'residuo'   => $temp % 2,
            ];
            $temp = intdiv($temp, 2);
        }

        return $pasos;
    }

    /**
     * Agrupa el binario en bloques de 4 dígitos (nibbles) para legibilidad.
     */
    public function agrupar(string $binario): string {
        $negativo = str_starts_with($binario, '-');
        $bits     = $negativo ? substr($binario, 1) : $binario;

        // Pad izquierdo para que sea múltiplo de 4
        $pad  = (4 - (strlen($bits) % 4)) % 4;
        $bits = str_repeat('0', $pad) . $bits;

        $grupos = str_split($bits, 4);
        $result = implode(' ', $grupos);

        return $negativo ? '-' . $result : $result;
    }
}
