<?php
require_once __DIR__ . '/Controller/BinarioController.php';
require_once __DIR__ . '/View/BinarioView.php';
$c = new BinarioController();
renderBinario($c->procesar());
