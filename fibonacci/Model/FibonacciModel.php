<?php
class FibonacciModel {
    public function fibonacci(int $n): array {
        if ($n <= 0) return [];
        if ($n === 1) return [0];
        $serie = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $serie[] = $serie[$i-1] + $serie[$i-2];
        }
        return $serie;
    }

    public function factorial(int $n): string {
        if ($n < 0) return '0';
        $result = '1';
        // Usar bcmath para números grandes
        for ($i = 2; $i <= $n; $i++) {
            $result = function_exists('bcmul')
                ? bcmul($result, (string)$i)
                : (string)((int)$result * $i);
        }
        return $result;
    }

    public function pasosFibonacci(int $n): array {
        $serie = $this->fibonacci($n);
        $pasos = [];
        for ($i = 0; $i < count($serie); $i++) {
            if ($i < 2) {
                $pasos[] = "F($i) = " . $serie[$i];
            } else {
                $pasos[] = "F($i) = F(".($i-1).") + F(".($i-2).") = {$serie[$i-1]} + {$serie[$i-2]} = {$serie[$i]}";
            }
        }
        return $pasos;
    }
}
