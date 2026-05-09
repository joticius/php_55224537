<?php
require_once __DIR__ . '/Controller/ArbolController.php';
require_once __DIR__ . '/View/ArbolView.php';
$c = new ArbolController();
renderArbol($c->procesar());
