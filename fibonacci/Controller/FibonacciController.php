<?php
require_once __DIR__ . '/../Model/FibonacciModel.php';

class FibonacciController {
    private FibonacciModel $model;
    public function __construct() { $this->model = new FibonacciModel(); }

    public function procesar(): array {
        $datos = ['n'=>'','op'=>'fibonacci','serie'=>null,'resultado'=>null,'pasos'=>[],'error'=>null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $n  = trim($_POST['n'] ?? '');
            $op = $_POST['op'] ?? 'fibonacci';
            $datos['n']  = htmlspecialchars($n);
            $datos['op'] = $op;

            if (!is_numeric($n) || (int)$n != $n) {
                $datos['error'] = 'Ingresa un número entero válido.';
            } elseif ((int)$n < 0) {
                $datos['error'] = 'El número debe ser mayor o igual a 0.';
            } elseif ($op === 'fibonacci' && (int)$n > 80) {
                $datos['error'] = 'Ingresa un número ≤ 80 para Fibonacci.';
            } elseif ($op === 'factorial' && (int)$n > 1000) {
                $datos['error'] = 'Ingresa un número ≤ 1000 para Factorial.';
            } else {
                $n = (int)$n;
                if ($op === 'fibonacci') {
                    $datos['serie'] = $this->model->fibonacci($n);
                    $datos['pasos'] = $this->model->pasosFibonacci($n);
                } else {
                    $datos['resultado'] = $this->model->factorial($n);
                }
            }
        }
        return $datos;
    }
}
