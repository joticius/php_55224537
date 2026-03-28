<?php

class ConjuntoModel {

    /**
     * Limpia y convierte un array a conjunto (sin duplicados, ordenado).
     */
    public function limpiar(array $numeros): array {
        $conjunto = array_unique(array_map('intval', $numeros));
        sort($conjunto);
        return array_values($conjunto);
    }

    /**
     * Unión: todos los elementos de A y B sin repetir.
     * A ∪ B
     */
    public function union(array $a, array $b): array {
        return $this->limpiar(array_merge($a, $b));
    }

    /**
     * Intersección: elementos que están en A y en B.
     * A ∩ B
     */
    public function interseccion(array $a, array $b): array {
        return $this->limpiar(array_values(array_intersect($a, $b)));
    }

    /**
     * Diferencia A - B: elementos de A que NO están en B.
     */
    public function diferencia(array $a, array $b): array {
        return $this->limpiar(array_values(array_diff($a, $b)));
    }
}
