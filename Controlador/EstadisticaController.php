<?php

require_once __DIR__ . '/../Modelo/EstadisticaModel.php';

class EstadisticaController {

    private EstadisticaModel $model;

    public function __construct() {
        $this->model = new EstadisticaModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'numeros'   => [],
            'promedio'  => null,
            'mediana'   => null,
            'moda'      => null,
            'ordenados' => [],
            'error'     => '',
            'ejecutado' => false,
            'rawInput'  => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $resultado;

        $raw = trim($_POST['numeros'] ?? '');
        $resultado['rawInput'] = htmlspecialchars($raw);

        if (empty($raw)) {
            $resultado['error'] = 'Por favor ingresa al menos un número.';
            return $resultado;
        }

        // Separar por coma, punto y coma o espacio
        $partes = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);

        $numeros = [];
        foreach ($partes as $parte) {
            // Permitir números reales con punto o coma decimal
            $parte = str_replace(',', '.', $parte);
            if (!is_numeric($parte)) {
                $resultado['error'] = "\"$parte\" no es un número válido. Usa punto como decimal (ej: 3.5).";
                return $resultado;
            }
            $numeros[] = (float) $parte;
        }

        if (count($numeros) < 2) {
            $resultado['error'] = 'Ingresa al menos 2 números para calcular estadísticas.';
            return $resultado;
        }

        if (count($numeros) > 100) {
            $resultado['error'] = 'Puedes ingresar máximo 100 números.';
            return $resultado;
        }

        $resultado['numeros']   = $numeros;
        $resultado['promedio']  = $this->model->promedio($numeros);
        $resultado['mediana']   = $this->model->mediana($numeros);
        $resultado['moda']      = $this->model->moda($numeros);
        $resultado['ordenados'] = $this->model->ordenar($numeros);
        $resultado['ejecutado'] = true;

        return $resultado;
    }
}
