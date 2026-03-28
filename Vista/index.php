<?php

require_once __DIR__ . '/Controlador/AcronimoController.php';


$controller = new AcronimoController();
$datos = $controller->manejarPeticion();


require_once __DIR__ . '/Vista/index.php';
