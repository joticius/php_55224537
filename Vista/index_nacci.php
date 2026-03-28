<?php

// =============================================
//  PUNTO DE ENTRADA — index.php (raíz)
//  Flujo: Controller → Model → View
// =============================================

require_once __DIR__ . '/Controlador/MatematicaController.php';

// 1. El Controlador procesa la petición y consulta el Modelo
$controller = new MatematicaController();
$datos = $controller->manejarPeticion();

// 2. La Vista recibe $datos y renderiza la interfaz
require_once __DIR__ . '/Vista/index.php';
