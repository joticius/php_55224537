<?php
require_once __DIR__ . '/../Model/AcronimoModel.php';

class AcronimoController {
    private AcronimoModel $model;
    public function __construct() { $this->model = new AcronimoModel(); }

    public function procesar(): array {
        $datos = ['frase' => '', 'acronimo' => null, 'error' => null];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $frase = trim($_POST['frase'] ?? '');
            $datos['frase'] = htmlspecialchars($frase);
            if ($frase === '') {
                $datos['error'] = 'Por favor ingresa una frase.';
            } else {
                $result = $this->model->convertir($frase);
                if ($result === '') {
                    $datos['error'] = 'La frase no contiene palabras válidas.';
                } else {
                    $datos['acronimo'] = $result;
                }
            }
        }
        return $datos;
    }
}
