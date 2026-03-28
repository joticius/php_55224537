<?php

// =============================================
//  PUNTO DE ENTRADA — index.php (raíz)
//  Flujo MVC: Controller → Model → View
// =============================================

require_once __DIR__ . '/Controller/ArbolController.php';

$controller = new ArbolController();
$datos = $controller->manejarPeticion();

require_once __DIR__ . '/View/index.php';
