<?php

// =============================================
//  PUNTO DE ENTRADA — index.php (raíz)
//  Flujo MVC: Controller → Model → View
// =============================================

require_once __DIR__ . '/Controller/ConjuntoController.php';

// 1. Controlador procesa la petición y consulta el Modelo
$controller = new ConjuntoController();
$datos = $controller->manejarPeticion();

// 2. Vista recibe $datos y renderiza la interfaz
require_once __DIR__ . '/View/index.php';
