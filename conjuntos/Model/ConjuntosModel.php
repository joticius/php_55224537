<?php
class ConjuntosModel {
    public function parsear(string $entrada): array {
        $partes = preg_split('/[\s,;{}]+/', trim($entrada), -1, PREG_SPLIT_NO_EMPTY);
        $nums = [];
        foreach ($partes as $p) {
            if (!is_numeric($p)) return [];
            $nums[] = (int)$p;
        }
        return array_values(array_unique($nums));
    }

    public function calcular(array $a, array $b): array {
        $union        = array_values(array_unique(array_merge($a, $b)));
        $interseccion = array_values(array_intersect($a, $b));
        $difAB        = array_values(array_diff($a, $b));
        $difBA        = array_values(array_diff($b, $a));
        sort($union); sort($interseccion); sort($difAB); sort($difBA);
        return compact('union','interseccion','difAB','difBA');
    }
}
