<?php
require_once __DIR__ . '/../Modelo/CalculatorModel.php';

class CalculatorController {
    private $model;

    public function __construct() {
        $this->model = new CalculatorModel();
    }

    public function handleRequest() {
        $result = null;
        $history = $this->model->getHistory();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['calculate'])) {
                $num1 = floatval($_POST['num1']);
                $num2 = floatval($_POST['num2']);
                $operation = $_POST['operation'];
                $result = $this->model->calculate($num1, $num2, $operation);
                $history = $this->model->getHistory();
            } elseif (isset($_POST['clear_history'])) {
                $this->model->clearHistory();
                $history = [];
            }
        }

        return [
            'result' => $result,
            'history' => $history
        ];
    }
}
?>