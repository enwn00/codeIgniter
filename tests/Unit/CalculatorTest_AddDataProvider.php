<?php

use PHPUnit\Framework\TestCase;
use App\Controller\Calculator;

// test 명령어 : vendor/bin/phpunit tests/Unit/CalculatorTest_AddDataProvider.php
class CalculatorTest_AddDataProvider extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    protected function tearDown(): void
    {
        $this->calculator = NULL;
    }

    public function addDataProvider(): array
    {
        return array(
            array(1,2,3),
            array(0,0,1), // 고의로 Error 발생
            array(-1,-1,-2),
        );
    }

    /**
     * @dataProvider addDataProvider
     * @param $a
     * @param $b
     * @param $expected
     */
    public function testAdd($a, $b, $expected)
    {
        $result = $this->calculator->add($a, $b);
        $this->assertEquals($expected, $result);
    }
}
