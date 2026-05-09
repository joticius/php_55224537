<?php
require_once __DIR__ . '/Controller/CalculadoraController.php';
require_once __DIR__ . '/View/CalculadoraView.php';
$c = new CalculadoraController();
renderCalculadora($c->procesar());
