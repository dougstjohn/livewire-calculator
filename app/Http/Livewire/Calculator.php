<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use NXP\MathExecutor;

// @todo change stack to . and display to be 0.
class Calculator extends Component
{
    public $stack; // Tracks user inputs
    public $display; // Text displayed on screen
    public $operators = ['+', '-', '*', '/']; // Regular operators
    public $calculationOperators = ['!', '%']; // Operators that force a calculation, excluding equals
    public $selectedOperator = null;
    public $lastOperatorPressed = null;

    public function mount()
    {
        $this->clear();
    }

    public function render()
    {
        return view('livewire.calculator');
    }

    public function clear()
    {
        $this->clearStack();
        $this->setDisplay();
        $this->lastOperatorPressed = null;
        $this->selectedOperator = null;
    }

    public function getClearTextProperty()
    {
        return $this->stackIsEmpty() ? 'AC' : 'C';
    }

    public function add()
    {
        $this->operator('+');
    }

    public function subtract()
    {
        $this->operator('-');
    }

    public function multiply()
    {
        $this->operator('*');
    }

    public function divide()
    {
        $this->operator('/');
    }

    public function negate()
    {
        $this->operator('!');
    }

    public function percent()
    {
        $this->operator('%');
    }

    private function operator($operator)
    {
        $this->lastOperatorPressed = $operator;

        if ($this->stackIsEmpty()) {
            $this->clear();
            return;
        } elseif ($this->stack == '0.' && $this->isACalculationOperator($operator)) {
            $this->clear();
            return;
        }

        $this->selectedOperator = $operator;

        // Replace last char if already an operator
        $lastCharInStack = substr($this->stack, -1) ?: '';
        if ($this->isAnOperator($operator) && $this->isAnOperator($lastCharInStack)) {
            $this->stack = substr($this->stack, 0, -1) . $operator;
            return;
        }

        if (! $this->shouldCalculate($operator)) {
            $this->addToStack($operator);
            $this->setDisplay();
            return;
        }

        try {
            $math = new MathExecutor();

            if ($this->isACalculationOperator($operator)) {
                $lastNumber = $this->getStackLastNumber();

                if ($operator == '!') {  
                    // Negate
                    $total = $math->execute("-1*" . (float)$lastNumber);
                } elseif ($operator == '%') {
                    // Percent
                    $total = $math->execute((float)$lastNumber . "/100");
                }
            } else {
                // Adjust stack for edgecases like 2+= or -2.2+= (Append first number to end)
                if ($operator == '=' && preg_match('/^(\-?\d*\.?\d*)([\+\-\*\/])$/', $this->stack, $chunks)) {
                    $this->stack .= $chunks[1];
                }

                // Issue with math package and floats
                preg_match('/^(\-?\d*\.?\d*)([\+\-\*\/])(\d*\.?\d*)$/', $this->stack, $chunks);
                $total = $math->execute((float)$chunks[1] . $chunks[2] . (float)$chunks[3]);
            }

            // Round decimal
            $total = round($total, 10);

            // Out of range
            if ($total > 999999999999 || $total < -999999999999) {
                throw new \Exception('Number out of range');
            }

            // Add operator to stack after calculating
            if ($this->isAnOperator($operator)) {
                $this->stack = $total . $operator;
            } else {
                $this->stack = $total;
            }

            $this->setDisplay();
        } catch (\Exception $e) {
            $this->clear();
            $this->setDisplay($e->getMessage());
        }
    }

    public function number($number)
    {
        if ($this->lastOperatorPressed === '=') {
            $this->clear();
        }

        $this->addToStack($number);
        $this->setDisplay();
    }

    public function decimal()
    {
        if ($this->lastOperatorPressed === '=') {
            $this->clear();
        }

        $lastCharInStack = substr($this->stack, -1) ?: '';

        if ($this->stackIsEmpty() || $this->isAnOperator($lastCharInStack)) {
            $this->addToStack('0.');
            $this->setDisplay();
            return;
        }

        // Last number in stack already has a period
        preg_match('/\d*\.?\d*$/', $this->stack, $chunks);
        if ($chunks[0] && Str::contains($chunks[0], '.')) {
            return;
        }

        $this->addToStack('.');
        $this->setDisplay();
    }

    public function equal()
    {
        $this->lastOperatorPressed = '=';

        // Period only
        if ($this->stack == '0.') {
            $this->clear();
            return;
        }

        // Number only
        if (preg_match('/^(\-?\d*\.?\d*)$/', $this->stack)) {
            return;
        }

        $this->operator('=');
    }

    private function stackIsEmpty()
    {
        return strlen($this->stack) === 0;
    }

    private function addToStack($char)
    {
        $lastCharInStack = substr($this->stack, -1) ?: '';
        
        if ($char === '.' && $lastCharInStack === '.') {
            return;
        }

        $this->stack .= $char;
    }
    
    private function clearStack()
    {
        $this->stack = '';
    }

    // Parse out one or two numbers and return the last one
    // Example format: 1 or -1 or 1*2 or -1*2
    private function getStackLastNumber()
    {
        preg_match('/^(\-?\d*\.?\d*)[\+\-\*\/]?(\d*\.?\d*)?$/', $this->stack, $chunks);
        $chunks = array_filter($chunks); // Remove empty strings
        
        return end($chunks);
    }

    private function setDisplay($message = null)
    {
        if ($message) {
            $this->display = $message;
            return;
        }

        $this->display = $this->getStackLastNumber() ?: '0';
    }

    private function clearDisplay()
    {
        $this->setDisplay(0);
    }
    
    private function isAnOperator($char)
    {
        return in_array($char, $this->operators, true);
    }

    private function isACalculationOperator($char)
    {
        return in_array($char, $this->calculationOperators, true);
    }

    private function shouldCalculate($operator)
    {
        return (
            $operator == '=' ||
            $this->isACalculationOperator($operator) || 
            ($this->isAnOperator($operator) && $validMathFormat = preg_match('/^(\-?\d*\.?\d*)([\+\-\*\/])(\d*\.?\d*)$/', $this->stack))
        );
    }
}