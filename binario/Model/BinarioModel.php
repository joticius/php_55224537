<?php
class BinarioModel {
    public function convertir(int $n): array {
        $negativo = $n < 0;
        $abs = abs($n);
        if ($abs === 0) {
            $binario = '0';
            $pasos   = [['dividendo'=>0,'cociente'=>0,'residuo'=>0]];
        } else {
            $binario = '';
            $pasos   = [];
            $tmp = $abs;
            while ($tmp > 0) {
                $r = $tmp % 2;
                $pasos[] = ['dividendo'=>$tmp,'cociente'=>intdiv($tmp,2),'residuo'=>$r];
                $binario = $r . $binario;
                $tmp = intdiv($tmp, 2);
            }
        }
        return [
            'decimal'  => $n,
            'binario'  => ($negativo ? '-' : '') . $binario,
            'bits'     => str_split($binario),
            'pasos'    => $pasos,
            'negativo' => $negativo,
        ];
    }
}
