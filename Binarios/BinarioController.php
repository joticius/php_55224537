<?php

require_once __DIR__ . '/../Model/BinarioModel.php';

class BinarioController {

    private BinarioModel $model;

    public function __construct() {
        $this->model = new BinarioModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'numero'   => '',
            'binario'  => '',
            'agrupado' => '',
            'pasos'    => [],
            'bits'     => 0,
            'error'    => '',
            'ejecutado'=> false,
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $resultado;

        $raw = trim($_POST['numero'] ?? '');

        if ($raw === '') {
            $resultado['error'] = 'Por favor ingresa un número entero.';
            return $resultado;
        }

        if (!preg_match('/^-?\d+$/', $raw)) {
            $resultado['error'] = "\"$raw\" no es un número entero válido.";
            return $resultado;
        }

        $n = (int) $raw;

        if ($n < -65535 || $n > 65535) {
            $resultado['error'] = 'Ingresa un número entre -65535 y 65535.';
            return $resultado;
        }

        $binario  = $this->model->toBinario($n);
        $agrupado = $this->model->agrupar($binario);
        $pasos    = $this->model->pasos(abs($n));
        $bits     = strlen(ltrim($binario, '-0')) ?: 1;

        $resultado['numero']    = $n;
        $resultado['binario']   = $binario;
        $resultado['agrupado']  = $agrupado;
        $resultado['pasos']     = $pasos;
        $resultado['bits']      = $bits;
        $resultado['ejecutado'] = true;

        return $resultado;
    }
}
