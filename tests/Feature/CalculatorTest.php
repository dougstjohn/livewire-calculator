<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Http\Livewire\Calculator;

class CalculatorTest extends TestCase
{
    public function testPageLoads()
    {
        $this->get('/')->assertStatus(200);

        Livewire::test(Calculator::class)
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testCalculatorElementsLoad()
    {
        Livewire::test(Calculator::class)
            ->assertSee(0)
            ->assertSee(1)
            ->assertSee(2)
            ->assertSee(3)
            ->assertSee(4)
            ->assertSee(5)
            ->assertSee(6)
            ->assertSee(7)
            ->assertSee(8)
            ->assertSee(9)
            ->assertSee('&plus;')
            ->assertSee('&minus;')
            ->assertSee('&times;')
            ->assertSee('&divide;')
            ->assertSee('&plusmn;')
            ->assertSee('&percnt;')
            ->assertSee('&middot;')  
            ->assertSee('&equals;')
            ->assertSee('AC'); // clear
    }

    public function testAddition()
    {
        Livewire::test(Calculator::class)
            ->call('number', 4)
            ->call('add')
            ->call('number', 4)
            ->call('equal')
            ->assertSet('stack', '8')
            ->assertSet('display', '8');
    }

    public function testSubtraction()
    {
        Livewire::test(Calculator::class)
            ->call('number', 8)
            ->call('subtract')
            ->call('number', 4)
            ->call('equal')
            ->assertSet('stack', '4')
            ->assertSet('display', '4');
    }

    public function testMultiplication()
    {
        Livewire::test(Calculator::class)
            ->call('number', 4)
            ->call('multiply')
            ->call('number', 4)
            ->call('equal')
            ->assertSet('stack', '16')
            ->assertSet('display', '16');
    }

    public function testDivision()
    {
        Livewire::test(Calculator::class)
            ->call('number', 4)
            ->call('divide')
            ->call('number', 4)
            ->call('equal')
            ->assertSet('stack', '1')
            ->assertSet('display', '1');
    }

    public function testMultiplyingANegativeNumber()
    {
        Livewire::test(Calculator::class)
            ->call('number', 1)
            ->call('negate')
            ->call('multiply')
            ->call('number', 5)
            ->call('equal')
            ->assertSet('stack', '-5')
            ->assertSet('display', '-5');
    }

    public function testNegate()
    {
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('negate')
            ->assertSet('stack', '-2')
            ->assertSet('display', '-2');
    }

    public function testNegateANegative()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('number', 10)
            ->call('equal')
            ->assertSet('stack', '-5')
            ->assertSet('display', '-5')
            ->call('negate')
            ->assertSet('stack', '5')
            ->assertSet('display', '5');
    }

    public function testNegateAndSkipEarlierInput()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('number', 10)
            ->call('negate')
            ->assertSet('stack', '-10')
            ->assertSet('display', '-10');
    }

    public function testNegateWithOperator()
    {
        // add
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('add')
            ->call('negate')
            ->assertSet('stack', '-2')
            ->assertSet('display', '-2');

        // sub
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('subtract')
            ->call('negate')
            ->assertSet('stack', '-2')
            ->assertSet('display', '-2');

        // mult
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('multiply')
            ->call('negate')
            ->assertSet('stack', '-2')
            ->assertSet('display', '-2');

        // div
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('divide')
            ->call('negate')
            ->assertSet('stack', '-2')
            ->assertSet('display', '-2');
    }

    public function testDecimalMath()
    {
        // add
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 25)
            ->call('add')
            ->call('decimal')
            ->call('number', 25)
            ->call('equal')
            ->assertSet('stack', '0.5')
            ->assertSet('display', '0.5');

        // sub
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 25)
            ->call('subtract')
            ->call('decimal')
            ->call('number', 15)
            ->call('equal')
            ->assertSet('stack', '0.1')
            ->assertSet('display', '0.1');

        // mult
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 3)
            ->call('multiply')
            ->call('decimal')
            ->call('number', 2)
            ->call('equal')
            ->assertSet('stack', '0.06')
            ->assertSet('display', '0.06');

        // div
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 3)
            ->call('divide')
            ->call('decimal')
            ->call('number', 12)
            ->call('equal')
            ->assertSet('stack', '2.5')
            ->assertSet('display', '2.5');
    }

    public function testDecimalPercent()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 25)
            ->call('percent')
            ->assertSet('stack', '0.0025')
            ->assertSet('display', '0.0025');
    }

    public function testDecimalNegate()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 25)
            ->call('negate')
            ->assertSet('stack', '-0.25')
            ->assertSet('display', '-0.25');
    }

    public function testDecimalPlusWholeNumber()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 3)
            ->call('add')
            ->call('number', 3)
            ->call('equal')
            ->assertSet('stack', '3.3')
            ->assertSet('display', '3.3');
    }

    public function testWholeNumberPlusDecimal()
    {
        Livewire::test(Calculator::class)
            ->call('number', 3)
            ->call('add')
            ->call('decimal')
            ->call('number', 3)
            ->call('equal')
            ->assertSet('stack', '3.3')
            ->assertSet('display', '3.3');
    }

    public function testDecimalWithoutDecimals()
    {
        Livewire::test(Calculator::class)
            ->call('number', '3.')
            ->call('add')
            ->call('number', 1)
            ->call('equal')
            ->assertSet('stack', '4')
            ->assertSet('display', '4');
    }

    public function testDecimalAndOperation()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->assertSet('stack', '0.')
            ->assertSet('display', '0.')
            ->call('add')
            ->call('number', '6')
            ->call('equal')
            ->assertSet('stack', '6')
            ->assertSet('display', '6');
    }

    public function testDecimalAndPercent()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->assertSet('stack', '0.')
            ->assertSet('display', '0.')
            ->call('percent')
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testDecimalAndNegate()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->assertSet('stack', '0.')
            ->assertSet('display', '0.')
            ->call('negate')
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testDecimalAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->assertSet('stack', '0.')
            ->assertSet('display', '0.')
            ->call('equal')
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testDecimalDisplay()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->assertSet('stack', '0.')
            ->assertSet('display', '0.')
            ->call('number', 9)
            ->assertSet('stack', '0.9')
            ->assertSet('display', '0.9')
            ->call('add')
            ->call('decimal')
            ->assertSet('stack', '0.9+0.')
            ->assertSet('display', '0.')
            ->call('number', 9)
            ->assertSet('stack', '0.9+0.9')
            ->assertSet('display', '0.9')
            ->call('equal')
            ->assertSet('stack', '1.8')
            ->assertSet('display', '1.8');
    }

    public function testEnteringDuplicateDecimalOnFirstNumberInStack()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 9)
            ->call('decimal')
            ->call('number', 9)
            ->assertSet('stack', '0.99')
            ->assertSet('display', '0.99');
    }

    public function testEnteringDuplicateDecimalOnSecondNumberInStack()
    {
        Livewire::test(Calculator::class)
            ->call('number', 9)
            ->call('add')
            ->call('decimal')
            ->call('number', 9)
            ->call('decimal')
            ->call('number', 9)
            ->assertSet('stack', '9+0.99')
            ->assertSet('display', '0.99');
    }
    
    public function testMaxDecimalPlaces()
    {
        Livewire::test(Calculator::class)
            ->call('number', 2)
            ->call('divide')
            ->call('number', 3)
            ->call('equal')
            ->assertSet('stack', '0.6666666667')
            ->assertSet('display', '0.6666666667');
    }

    public function testLargePositiveDecimalTotal()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 9999999999)
            ->call('add')
            ->call('decimal')
            ->call('number', 99999999999)
            ->call('equal')
            ->assertSet('stack', '1.9999999999')
            ->assertSet('display', '1.9999999999');
    }

    public function testLargeNegativeDecimalTotal()
    {
        Livewire::test(Calculator::class)
            ->call('decimal')
            ->call('number', 9)
            ->call('negate')
            ->call('subtract')
            ->call('decimal')
            ->call('number', 999999999999999)
            ->call('equal')
            ->assertSet('stack', '-1.9')
            ->assertSet('display', '-1.9');
    }

    public function testPercent()
    {
        Livewire::test(Calculator::class)
            ->call('number', 25)
            ->call('percent')
            ->assertSet('stack', '0.25')
            ->assertSet('display', '0.25');
    }
    
    public function testPercentWithOperator()
    {
        // add
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('add')
            ->call('percent')
            ->assertSet('stack', '0.05')
            ->assertSet('display', '0.05');

        // sub
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('percent')
            ->assertSet('stack', '0.05')
            ->assertSet('display', '0.05');

        // mult
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('multiply')
            ->call('percent')
            ->assertSet('stack', '0.05')
            ->assertSet('display', '0.05');

        // div
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('divide')
            ->call('percent')
            ->assertSet('stack', '0.05')
            ->assertSet('display', '0.05');
    }

    public function testAddAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('add')
            ->call('equal')
            ->assertSet('stack', '10')
            ->assertSet('display', '10');
    }

    public function testSubtractAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('equal')
            ->assertSet('stack', '0')
            ->assertSet('display', '0');
    }

    public function testMultiplyAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('multiply')
            ->call('equal')
            ->assertSet('stack', '25')
            ->assertSet('display', '25');
    }

    public function testDivideAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('divide')
            ->call('equal')
            ->assertSet('stack', '1')
            ->assertSet('display', '1');
    }

    public function testNumberAndEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('equal')
            ->assertSet('stack', '5')
            ->assertSet('display', '5');
    }

    public function testDisplayingNegativeNumbers()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('number', 10)
            ->call('equal')
            ->assertSet('stack', '-5')
            ->assertSet('display', '-5');
    }

    public function testClear()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('subtract')
            ->call('clear')
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testCalculatingWithoutPressingEquals()
    {
        Livewire::test(Calculator::class)
            ->call('number', 4)
            ->call('add')
            ->call('number', 4)
            ->call('add')
            ->assertSet('stack', '8+')
            ->assertSet('display', '8');
    }

    public function testInvalidFirstInputs()
    {
        // add
        Livewire::test(Calculator::class)
            ->call('add')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // sub
        Livewire::test(Calculator::class)
            ->call('subtract')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // mult
        Livewire::test(Calculator::class)
            ->call('multiply')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // div
        Livewire::test(Calculator::class)
            ->call('divide')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // negate
        Livewire::test(Calculator::class)
            ->call('negate')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // percent
        Livewire::test(Calculator::class)
            ->call('percent')
            ->assertSet('stack', '')
            ->assertSet('display', '0');

        // equals
        Livewire::test(Calculator::class)
            ->call('equal')
            ->assertSet('stack', '')
            ->assertSet('display', '0');
    }

    public function testChangingOperator()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('add')
            ->call('subtract')
            ->call('multiply')
            ->call('divide') // Uses last
            ->call('number', 5)
            ->call('equal')
            ->assertSet('stack', '1')
            ->assertSet('display', '1');
    }

    public function testSameOperatorTwice()
    {
        Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('multiply')
            ->call('multiply')
            ->call('number', 5)
            ->call('equal')
            ->assertSet('stack', '25')
            ->assertSet('display', '25');
    }

    public function testOperatorAndNegate()
    {
        Livewire::test(Calculator::class)
            ->call('number', 7)
            ->call('add')
            ->call('negate')
            ->assertSet('stack', '-7')
            ->assertSet('display', '-7');
    }

    public function testOperatorAndPercent()
    {
        Livewire::test(Calculator::class)
            ->call('number', 7)
            ->call('add')
            ->call('percent')
            ->assertSet('stack', '0.07')
            ->assertSet('display', '0.07');
    }

    public function testDivideByZero()
    {
        Livewire::test(Calculator::class)
            ->call('number', 4)
            ->call('divide')
            ->call('number', 0)
            ->call('equal')
            ->assertSet('stack', '0')
            ->assertSet('display', '0');
    }

    public function testLargePositiveTotal()
    {
        Livewire::test(Calculator::class)
            ->call('number', 99999999999)
            ->call('add')
            ->call('number', 999999999999)
            ->call('equal')
            ->assertSet('stack', '')
            ->assertSet('display', 'Number out of range');
    }

    public function testLargeNegativeTotal()
    {
        Livewire::test(Calculator::class)
            ->call('number', 1)
            ->call('subtract')
            ->call('number', 9999999999999)
            ->call('equal')
            ->assertSet('stack', '')
            ->assertSet('display', 'Number out of range');
    }

    public function testStartOverIfNumberEnteredAfterEqualPressed()
    {
        $calc = Livewire::test(Calculator::class)
            ->call('number', 5)
            ->call('add')
            ->call('number', 1)
            ->call('equal')
            ->assertSet('stack', '6')
            ->assertSet('display', '6');

        // Clears upon user input
        $calc->call('number', 5)
            ->assertSet('stack', '5')
            ->assertSet('display', '5');
    }
}