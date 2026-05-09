<?php
require_once __DIR__ . '/Controller/AcronimoController.php';
require_once __DIR__ . '/View/AcronimoView.php';

$controller = new AcronimoController();
$datos = $controller->procesar();
renderAcronimo($datos);
