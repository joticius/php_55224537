<?php

require_once __DIR__ . '/../Modelo/AcronimoModel.php';

class AcronimoController {

    private AcronimoModel $model;

    public function __construct() {
        $this->model = new AcronimoModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'frase'    => '',
            'acronimo' => '',
            'error'    => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $frase = trim($_POST['frase'] ?? '');

            if (empty($frase)) {
                $resultado['error'] = 'Por favor, ingresa una frase.';
            } else {
                $resultado['frase']    = htmlspecialchars($frase);
                $resultado['acronimo'] = $this->model->convertirAcronimo($frase);
            }
        }

        return $resultado;
    }
}
