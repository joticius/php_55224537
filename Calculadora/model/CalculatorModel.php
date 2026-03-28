&lt;?php
session_start();

class CalculatorModel {
    private $history;

    public function __construct() {
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        $this->history = &$_SESSION['history'];
    }

    public function calculate($num1, $num2, $operation) {
        $result = null;
        $expression = "$num1 $operation $num2";

        switch ($operation) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = 'Error: División por cero';
                }
                break;
            case '%':
                $result = ($num1 * $num2) / 100; // Asumiendo porcentaje como num1% de num2
                break;
            default:
                $result = 'Operación no válida';
        }

        $this->addToHistory("$expression = $result");
        return $result;
    }

    public function addToHistory($entry) {
        array_push($this->history, $entry);
    }

    public function getHistory() {
        return $this->history;
    }

    public function clearHistory() {
        $this->history = [];
    }
}
?&gt;
