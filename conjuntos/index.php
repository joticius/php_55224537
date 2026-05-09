<?php
require_once __DIR__ . '/Controller/ConjuntosController.php';
require_once __DIR__ . '/View/ConjuntosView.php';
$c = new ConjuntosController();
renderConjuntos($c->procesar());
