<?php

class ArbolModel {

    // ─── Nodo del árbol ───────────────────────────────────────
    private function nodo(string $val, ?array $izq = null, ?array $der = null): array {
        return ['val' => $val, 'izq' => $izq, 'der' => $der];
    }

    // ══════════════════════════════════════════════════════════
    //  CONSTRUCCIÓN: Preorden + Inorden
    // ══════════════════════════════════════════════════════════
    public function desdePre_In(array $pre, array $ino): ?array {
        if (empty($pre) || empty($ino)) return null;

        $raiz = $pre[0];
        $idx  = array_search($raiz, $ino);
        if ($idx === false) return null;

        $inoIzq = array_slice($ino, 0, $idx);
        $inoDer = array_slice($ino, $idx + 1);
        $preIzq = array_slice($pre, 1, count($inoIzq));
        $preDer = array_slice($pre, 1 + count($inoIzq));

        return $this->nodo(
            $raiz,
            $this->desdePre_In($preIzq, $inoIzq),
            $this->desdePre_In($preDer, $inoDer)
        );
    }

    // ══════════════════════════════════════════════════════════
    //  CONSTRUCCIÓN: Postorden + Inorden
    // ══════════════════════════════════════════════════════════
    public function desdePost_In(array $post, array $ino): ?array {
        if (empty($post) || empty($ino)) return null;

        $raiz = end($post);
        $idx  = array_search($raiz, $ino);
        if ($idx === false) return null;

        $inoIzq  = array_slice($ino, 0, $idx);
        $inoDer  = array_slice($ino, $idx + 1);
        $postIzq = array_slice($post, 0, count($inoIzq));
        $postDer = array_slice($post, count($inoIzq), count($inoDer));

        return $this->nodo(
            $raiz,
            $this->desdePost_In($postIzq, $inoIzq),
            $this->desdePost_In($postDer, $inoDer)
        );
    }

    // ══════════════════════════════════════════════════════════
    //  CONSTRUCCIÓN: Preorden + Postorden
    //  (solo funciona si el árbol es estrictamente binario)
    // ══════════════════════════════════════════════════════════
    public function desdePre_Post(array $pre, array $post): ?array {
        if (empty($pre)) return null;
        if (count($pre) === 1) return $this->nodo($pre[0]);

        $raiz    = $pre[0];
        $hijoIzq = $pre[1];
        $idx     = array_search($hijoIzq, $post);
        if ($idx === false) return null;

        $tamIzq  = $idx + 1;
        $preIzq  = array_slice($pre,  1, $tamIzq);
        $preDer  = array_slice($pre,  1 + $tamIzq);
        $postIzq = array_slice($post, 0, $tamIzq);
        $postDer = array_slice($post, $tamIzq, count($preDer));

        return $this->nodo(
            $raiz,
            $this->desdePre_Post($preIzq,  $postIzq),
            $this->desdePre_Post($preDer,   $postDer)
        );
    }

    // ══════════════════════════════════════════════════════════
    //  RECORRIDOS sobre el árbol construido
    // ══════════════════════════════════════════════════════════
    public function preorden(?array $nodo): array {
        if (!$nodo) return [];
        return array_merge([$nodo['val']], $this->preorden($nodo['izq']), $this->preorden($nodo['der']));
    }

    public function inorden(?array $nodo): array {
        if (!$nodo) return [];
        return array_merge($this->inorden($nodo['izq']), [$nodo['val']], $this->inorden($nodo['der']));
    }

    public function postorden(?array $nodo): array {
        if (!$nodo) return [];
        return array_merge($this->postorden($nodo['izq']), $this->postorden($nodo['der']), [$nodo['val']]);
    }

    // ══════════════════════════════════════════════════════════
    //  SERIALIZACIÓN por niveles para dibujar en SVG
    //  Retorna array de nodos con posición x, y y referencias a padre
    // ══════════════════════════════════════════════════════════
    public function serializar(?array $raiz): array {
        if (!$raiz) return [];

        $nodos  = [];
        $cola   = [['nodo' => $raiz, 'padre' => -1, 'lado' => '', 'nivel' => 0, 'id' => 0]];
        $sig    = 1;

        while (!empty($cola)) {
            $item  = array_shift($cola);
            $nodo  = $item['nodo'];
            $nodos[$item['id']] = [
                'id'     => $item['id'],
                'val'    => $nodo['val'],
                'padre'  => $item['padre'],
                'lado'   => $item['lado'],
                'nivel'  => $item['nivel'],
            ];

            if ($nodo['izq']) {
                $cola[] = ['nodo' => $nodo['izq'], 'padre' => $item['id'],
                           'lado' => 'izq', 'nivel' => $item['nivel'] + 1, 'id' => $sig++];
            }
            if ($nodo['der']) {
                $cola[] = ['nodo' => $nodo['der'], 'padre' => $item['id'],
                           'lado' => 'der', 'nivel' => $item['nivel'] + 1, 'id' => $sig++];
            }
        }

        // Calcular posiciones X usando recorrido inorden del árbol original
        $inorden = $this->inorden($raiz);
        $orden   = array_flip($inorden);   // valor → posición horizontal

        $maxNivel = max(array_column($nodos, 'nivel'));
        $alturaTotal = ($maxNivel + 1) * 90 + 60;

        foreach ($nodos as &$n) {
            $pos     = $orden[$n['val']] ?? 0;
            $total   = count($inorden);
            $n['x']  = round(($pos + 0.5) / $total * 100, 2);  // % del ancho
            $n['y']  = 50 + $n['nivel'] * 90;
        }

        return ['nodos' => $nodos, 'altura' => $alturaTotal];
    }
}
