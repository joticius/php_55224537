<?php
require_once __DIR__ . '/../Model/EstadisticaModel.php';

class EstadisticaController {
    private EstadisticaModel $model;
    public function __construct() { $this->model = new EstadisticaModel(); }

    public function procesar(): array {
        $datos = ['entrada'=>'','resultado'=>null,'error'=>null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = trim($_POST['numeros'] ?? '');
            $datos['entrada'] = htmlspecialchars($entrada);
            if ($entrada === '') {
                $datos['error'] = 'Ingresa al menos un número.';
            } else {
                $nums = $this->model->parsearEntrada($entrada);
                if (empty($nums)) {
                    $datos['error'] = 'Entrada inválida. Usa números separados por comas o espacios.';
                } elseif (count($nums) < 2) {
                    $datos['error'] = 'Ingresa al menos 2 números.';
                } else {
                    $datos['resultado'] = $this->model->calcular($nums);
                }
            }
        }
        return $datos;
    }
}
