<?php
require_once __DIR__ . '/../Model/BinarioModel.php';

class BinarioController {
    private BinarioModel $model;
    public function __construct() { $this->model = new BinarioModel(); }

    public function procesar(): array {
        $datos = ['n'=>'','resultado'=>null,'error'=>null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $n = trim($_POST['n'] ?? '');
            $datos['n'] = htmlspecialchars($n);
            if ($n === '' || !preg_match('/^-?\d+$/', $n)) {
                $datos['error'] = 'Ingresa un número entero válido.';
            } elseif (abs((int)$n) > 9999999) {
                $datos['error'] = 'Ingresa un número entre -9.999.999 y 9.999.999.';
            } else {
                $datos['resultado'] = $this->model->convertir((int)$n);
            }
        }
        return $datos;
    }
}
