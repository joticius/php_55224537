<?php

require_once __DIR__ . '/Controller/AcronimoController.php';


$controller = new AcronimoController();
$datos = $controller->manejarPeticion();


require_once __DIR__ . '/View/index.php';
