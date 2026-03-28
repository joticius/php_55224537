<?php

require_once __DIR__ . '/../Modelo/ArbolModel.php';

class ArbolController {

    private ArbolModel $model;

    public function __construct() {
        $this->model = new ArbolModel();
    }

    public function manejarPeticion(): array {
        $resultado = [
            'arbol'      => null,
            'svg'        => [],
            'preorden'   => [],
            'inorden'    => [],
            'postorden'  => [],
            'modo'       => '',
            'rawPre'     => '',
            'rawIn'      => '',
            'rawPost'    => '',
            'error'      => '',
            'ejecutado'  => false,
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $resultado;

        $rawPre  = trim($_POST['preorden']  ?? '');
        $rawIn   = trim($_POST['inorden']   ?? '');
        $rawPost = trim($_POST['postorden'] ?? '');

        $resultado['rawPre']  = htmlspecialchars($rawPre);
        $resultado['rawIn']   = htmlspecialchars($rawIn);
        $resultado['rawPost'] = htmlspecialchars($rawPost);

        // Contar cuántos recorridos fueron ingresados
        $dados = array_filter([$rawPre, $rawIn, $rawPost], fn($r) => $r !== '');
        if (count($dados) < 2) {
            $resultado['error'] = 'Debes ingresar al menos dos recorridos.';
            return $resultado;
        }

        // Parsear cada recorrido
        $pre  = $rawPre  !== '' ? $this->parsear($rawPre)  : null;
        $ino  = $rawIn   !== '' ? $this->parsear($rawIn)   : null;
        $post = $rawPost !== '' ? $this->parsear($rawPost) : null;

        // Validar longitudes iguales entre los recorridos ingresados
        $lens = array_filter([
            $pre  ? count($pre)  : null,
            $ino  ? count($ino)  : null,
            $post ? count($post) : null,
        ], fn($v) => $v !== null);

        if (count(array_unique($lens)) > 1) {
            $resultado['error'] = 'Los recorridos ingresados deben tener la misma cantidad de nodos.';
            return $resultado;
        }

        // Verificar que no haya nodos repetidos dentro de un mismo recorrido
        foreach (['Preorden' => $pre, 'Inorden' => $ino, 'Postorden' => $post] as $nombre => $r) {
            if ($r !== null && count($r) !== count(array_unique($r))) {
                $resultado['error'] = "$nombre contiene valores duplicados.";
                return $resultado;
            }
        }

        // Construir el árbol según los recorridos disponibles
        $arbol = null;
        $modo  = '';

        if ($pre !== null && $ino !== null) {
            $arbol = $this->model->desdePre_In($pre, $ino);
            $modo  = 'Preorden + Inorden';
        } elseif ($post !== null && $ino !== null) {
            $arbol = $this->model->desdePost_In($post, $ino);
            $modo  = 'Postorden + Inorden';
        } elseif ($pre !== null && $post !== null) {
            $arbol = $this->model->desdePre_Post($pre, $post);
            $modo  = 'Preorden + Postorden';
        }

        if (!$arbol) {
            $resultado['error'] = 'No se pudo construir el árbol. Verifica que los recorridos sean consistentes.';
            return $resultado;
        }

        $resultado['arbol']     = $arbol;
        $resultado['svg']       = $this->model->serializar($arbol);
        $resultado['preorden']  = $this->model->preorden($arbol);
        $resultado['inorden']   = $this->model->inorden($arbol);
        $resultado['postorden'] = $this->model->postorden($arbol);
        $resultado['modo']      = $modo;
        $resultado['ejecutado'] = true;

        return $resultado;
    }

    private function parsear(string $raw): array {
        // Acepta separación por coma, espacio, guión o flecha →
        $raw = preg_replace('/→|->/', ',', $raw);
        $partes = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY);
        return array_map('strtoupper', $partes);
    }
}
