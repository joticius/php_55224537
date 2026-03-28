&lt;?php
require_once 'controller/CalculatorController.php';

$controller = new CalculatorController();
$data = $controller->handleRequest();

include 'view/calculator.php';
?&gt;