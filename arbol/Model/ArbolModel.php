<?php
class NodoArbol {
    public string $valor;
    public ?NodoArbol $izq = null;
    public ?NodoArbol $der = null;
    public function __construct(string $v) { $this->valor = $v; }
}

class ArbolModel {
    public function parsear(string $s): array {
        return preg_split('/[\s,\-\>→]+/u', trim($s), -1, PREG_SPLIT_NO_EMPTY);
    }

    /** Reconstruir desde preorden + inorden */
    public function preIn(array $pre, array $in): ?NodoArbol {
        if (empty($pre) || empty($in)) return null;
        $raiz  = new NodoArbol($pre[0]);
        $idx   = array_search($pre[0], $in);
        if ($idx === false) return $raiz;
        $inIzq = array_slice($in, 0, $idx);
        $inDer = array_slice($in, $idx + 1);
        $raiz->izq = $this->preIn(array_slice($pre, 1, count($inIzq)), $inIzq);
        $raiz->der = $this->preIn(array_slice($pre, 1 + count($inIzq)), $inDer);
        return $raiz;
    }

    /** Reconstruir desde postorden + inorden */
    public function postIn(array $post, array $in): ?NodoArbol {
        if (empty($post) || empty($in)) return null;
        $raiz  = new NodoArbol(end($post));
        $idx   = array_search(end($post), $in);
        if ($idx === false) return $raiz;
        $inIzq  = array_slice($in, 0, $idx);
        $inDer  = array_slice($in, $idx + 1);
        $raiz->izq = $this->postIn(array_slice($post, 0, count($inIzq)), $inIzq);
        $raiz->der = $this->postIn(array_slice($post, count($inIzq), count($inDer)), $inDer);
        return $raiz;
    }

    /** Construir layout de nodos para SVG (BFS) */
    public function layout(?NodoArbol $raiz): array {
        if (!$raiz) return [];
        $nodos  = [];
        $cola   = [[$raiz, 0, 0, -1, '']]; // [nodo, nivel, pos_x, parent_id, lado]
        $id     = 0;
        $anchos = []; // ancho por nivel

        // BFS para asignar coordenadas
        $queue  = [[$raiz, null, 0]]; // [nodo, padre_id, nivel]
        $posMap = [];
        $niveles= [];
        $bfs    = function() use (&$queue,&$posMap,&$niveles,&$id,&$bfs,&$nodos) {
            while (!empty($queue)) {
                [$nodo,$padreId,$nivel] = array_shift($queue);
                $myId = $id++;
                $niveles[$nivel][] = $myId;
                $nodos[$myId] = ['valor'=>$nodo->valor,'nivel'=>$nivel,'padre'=>$padreId,'x'=>0,'y'=>0,'izq'=>null,'der'=>null];
                if ($padreId !== null) {
                    if ($nodos[$padreId]['izq'] === null) $nodos[$padreId]['izq'] = $myId;
                    else $nodos[$padreId]['der'] = $myId;
                }
                if ($nodo->izq) $queue[] = [$nodo->izq, $myId, $nivel+1];
                if ($nodo->der) $queue[] = [$nodo->der, $myId, $nivel+1];
            }
        };
        $bfs();

        // Asignar x por posición en nivel
        foreach ($niveles as $niv => $ids) {
            $total = count($ids);
            foreach ($ids as $i => $mid) {
                $nodos[$mid]['x'] = ($i + 1) / ($total + 1);
                $nodos[$mid]['y'] = $niv;
            }
        }
        return ['nodos'=>$nodos,'niveles'=>$niveles];
    }
}
