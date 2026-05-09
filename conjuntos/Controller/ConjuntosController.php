<?php
require_once __DIR__ . '/../Model/ConjuntosModel.php';

class ConjuntosController {
    private ConjuntosModel $model;
    public function __construct() { $this->model = new ConjuntosModel(); }

    public function procesar(): array {
        $datos = ['a'=>'','b'=>'','resultado'=>null,'setA'=>[],'setB'=>[],'error'=>null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ea = trim($_POST['a'] ?? '');
            $eb = trim($_POST['b'] ?? '');
            $datos['a'] = htmlspecialchars($ea);
            $datos['b'] = htmlspecialchars($eb);
            $a = $this->model->parsear($ea);
            $b = $this->model->parsear($eb);
            if ($ea === '' || $eb === '') {
                $datos['error'] = 'Ingresa ambos conjuntos.';
            } elseif (empty($a) || empty($b)) {
                $datos['error'] = 'Los conjuntos deben contener números enteros válidos.';
            } else {
                $datos['setA']      = $a;
                $datos['setB']      = $b;
                $datos['resultado'] = $this->model->calcular($a, $b);
            }
        }
        return $datos;
    }
}
