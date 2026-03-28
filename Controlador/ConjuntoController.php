<?php

require_once __DIR__ . '/../Modelo/ConjuntoModel.php';

class ConjuntoController {

    private ConjuntoModel $model;

    public function __construct() {
        $this->model = new ConjuntoModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'setA'         => [],
            'setB'         => [],
            'union'        => [],
            'interseccion' => [],
            'difAB'        => [],
            'difBA'        => [],
            'rawA'         => '',
            'rawB'         => '',
            'error'        => '',
            'ejecutado'    => false,
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $resultado;

        $rawA = trim($_POST['conjuntoA'] ?? '');
        $rawB = trim($_POST['conjuntoB'] ?? '');

        $resultado['rawA'] = htmlspecialchars($rawA);
        $resultado['rawB'] = htmlspecialchars($rawB);

        if (empty($rawA) || empty($rawB)) {
            $resultado['error'] = 'Debes ingresar ambos conjuntos.';
            return $resultado;
        }

        $parsedA = $this->parsear($rawA, 'A');
        $parsedB = $this->parsear($rawB, 'B');

        if (isset($parsedA['error'])) { $resultado['error'] = $parsedA['error']; return $resultado; }
        if (isset($parsedB['error'])) { $resultado['error'] = $parsedB['error']; return $resultado; }

        $setA = $this->model->limpiar($parsedA);
        $setB = $this->model->limpiar($parsedB);

        $resultado['setA']         = $setA;
        $resultado['setB']         = $setB;
        $resultado['union']        = $this->model->union($setA, $setB);
        $resultado['interseccion'] = $this->model->interseccion($setA, $setB);
        $resultado['difAB']        = $this->model->diferencia($setA, $setB);
        $resultado['difBA']        = $this->model->diferencia($setB, $setA);
        $resultado['ejecutado']    = true;

        return $resultado;
    }

    private function parsear(string $raw, string $nombre): array {
        $partes = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);

        if (count($partes) === 0) {
            return ['error' => "El conjunto $nombre está vacío."];
        }

        if (count($partes) > 50) {
            return ['error' => "El conjunto $nombre puede tener máximo 50 elementos."];
        }

        $numeros = [];
        foreach ($partes as $p) {
            if (!preg_match('/^-?\d+$/', $p)) {
                return ['error' => "\"$p\" no es un entero válido en el conjunto $nombre."];
            }
            $numeros[] = (int) $p;
        }

        return $numeros;
    }
}
