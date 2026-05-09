<?php
require_once __DIR__ . '/Controller/FibonacciController.php';
require_once __DIR__ . '/View/FibonacciView.php';
$c = new FibonacciController();
renderFibonacci($c->procesar());
