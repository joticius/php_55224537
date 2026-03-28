<?php

require_once __DIR__ . '/../Model/MatematicaModel.php';

class MatematicaController {

    private MatematicaModel $model;

    public function __construct() {
        $this->model = new MatematicaModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'numero'    => '',
            'operacion' => '',
            'serie'     => [],
            'pasos'     => [],
            'error'     => '',
            'ejecutado' => false
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $resultado;

        $numero    = trim($_POST['numero']    ?? '');
        $operacion = trim($_POST['operacion'] ?? '');

        // Validaciones
        if ($numero === '' || !is_numeric($numero)) {
            $resultado['error'] = 'Por favor ingresa un número válido.';
            return $resultado;
        }

        $numero = (int) $numero;

        if ($numero < 0) {
            $resultado['error'] = 'El número debe ser mayor o igual a 0.';
            return $resultado;
        }

        if ($numero > 20 && $operacion === 'factorial') {
            $resultado['error'] = 'Para factorial, ingresa un número entre 0 y 20.';
            return $resultado;
        }

        if ($numero > 50 && $operacion === 'fibonacci') {
            $resultado['error'] = 'Para Fibonacci, ingresa un número entre 1 y 50.';
            return $resultado;
        }

        if (!in_array($operacion, ['fibonacci', 'factorial'])) {
            $resultado['error'] = 'Selecciona una operación válida.';
            return $resultado;
        }

        $resultado['numero']    = $numero;
        $resultado['operacion'] = $operacion;
        $resultado['ejecutado'] = true;

        if ($operacion === 'fibonacci') {
            $resultado['serie'] = $this->model->fibonacci($numero);
        } else {
            $resultado['pasos'] = $this->model->factorial($numero);
        }

        return $resultado;
    }
}
