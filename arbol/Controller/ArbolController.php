<?php
require_once __DIR__ . '/../Model/ArbolModel.php';

class ArbolController {
    private ArbolModel $model;
    public function __construct() { $this->model = new ArbolModel(); }

    public function procesar(): array {
        $datos = ['pre'=>'','in'=>'','post'=>'','raiz'=>null,'layout'=>null,'error'=>null,'modo'=>''];
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $datos;

        $pre  = trim($_POST['pre']  ?? '');
        $in   = trim($_POST['in']   ?? '');
        $post = trim($_POST['post'] ?? '');
        $datos['pre']  = htmlspecialchars($pre);
        $datos['in']   = htmlspecialchars($in);
        $datos['post'] = htmlspecialchars($post);

        $arrPre  = $pre  !== '' ? $this->model->parsear($pre)  : [];
        $arrIn   = $in   !== '' ? $this->model->parsear($in)   : [];
        $arrPost = $post !== '' ? $this->model->parsear($post) : [];

        // necesitamos al menos 2 de los 3
        $provistos = ($pre!==''?1:0) + ($in!==''?1:0) + ($post!==''?1:0);
        if ($provistos < 2) {
            $datos['error'] = 'Ingresa al menos dos recorridos para reconstruir el árbol.';
            return $datos;
        }

        // validar que todos tengan el mismo largo
        $lens = array_filter([count($arrPre),count($arrIn),count($arrPost)]);
        if (count(array_unique($lens)) > 1) {
            $datos['error'] = 'Los recorridos ingresados no tienen la misma cantidad de nodos.';
            return $datos;
        }

        $raiz = null;
        if ($in !== '' && $pre !== '') {
            $raiz = $this->model->preIn($arrPre, $arrIn);
            $datos['modo'] = 'Preorden + Inorden';
        } elseif ($in !== '' && $post !== '') {
            $raiz = $this->model->postIn($arrPost, $arrIn);
            $datos['modo'] = 'Postorden + Inorden';
        } elseif ($pre !== '' && $post !== '') {
            // derivar inorden desde pre + post (solo si árbol completo)
            // solución simple: usar preorden como guía
            $datos['error'] = 'Para reconstruir el árbol usa Inorden junto con Preorden o Postorden.';
            return $datos;
        }

        if ($raiz) {
            $datos['raiz']   = $raiz;
            $datos['layout'] = $this->model->layout($raiz);
        }
        return $datos;
    }
}
