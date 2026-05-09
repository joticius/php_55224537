<?php
class AcronimoModel {
    public function convertir(string $frase): string {
        // guiones son separadores, igual que espacios
        $frase = str_replace('-', ' ', $frase);
        // eliminar puntuación excepto espacios
        $frase = preg_replace('/[^\p{L}\p{N}\s]/u', '', $frase);
        $palabras = preg_split('/\s+/', trim($frase), -1, PREG_SPLIT_NO_EMPTY);
        $acronimo = '';
        foreach ($palabras as $p) {
            $acronimo .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $acronimo;
    }
}
