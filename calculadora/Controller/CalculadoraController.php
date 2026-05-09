<?php
require_once __DIR__ . '/../Model/CalculadoraModel.php';

class CalculadoraController {
    private CalculadoraModel $model;

    public function __construct() {
        $this->model = new CalculadoraModel();
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['historial'])) $_SESSION['historial'] = [];
    }

    public function procesar(): array {
        $datos = ['a'=>'','b'=>'','op'=>'+','resultado'=>null,'error'=>null,'historial'=>[]];

        // Borrar historial
        if (isset($_POST['borrar_historial'])) {
            $_SESSION['historial'] = [];
        }

        // Calcular
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calcular'])) {
            $a  = trim($_POST['a']  ?? '');
            $b  = trim($_POST['b']  ?? '');
            $op = trim($_POST['op'] ?? '+');
            $datos['a']  = htmlspecialchars($a);
            $datos['b']  = htmlspecialchars($b);
            $datos['op'] = $op;

            if (!is_numeric($a) || !is_numeric($b)) {
                $datos['error'] = 'Ingresa dos números válidos (enteros o decimales).';
            } else {
                $res = $this->model->calcular((float)$a, (float)$b, $op);
                if ($res['error']) {
                    $datos['error'] = $res['error'];
                } else {
                    $datos['resultado'] = $res['resultado'];
                    // Guardar en historial (máx 20 entradas)
                    $entrada = [
                        'a'         => $this->model->formatear((float)$a),
                        'b'         => $this->model->formatear((float)$b),
                        'op'        => $op,
                        'simbolo'   => $this->model->simboloOp($op),
                        'resultado' => $this->model->formatear($res['resultado']),
                        'hora'      => date('H:i:s'),
                    ];
                    array_unshift($_SESSION['historial'], $entrada);
                    if (count($_SESSION['historial']) > 20) array_pop($_SESSION['historial']);
                }
            }
        }

        $datos['historial'] = $_SESSION['historial'];
        return $datos;
    }
}
