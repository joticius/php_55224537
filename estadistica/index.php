<?php
require_once __DIR__ . '/Controller/EstadisticaController.php';
require_once __DIR__ . '/View/EstadisticaView.php';
$c = new EstadisticaController();
renderEstadistica($c->procesar());
