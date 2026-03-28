<?php
require_once __DIR__ . '/Controlador/CalculatorController.php';

$controller = new CalculatorController();
$data = $controller->handleRequest();

include __DIR__ . '/Vista/calculator.php';
?>