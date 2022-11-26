<?php

use PHPUnit\Framework\TestCase;
use App\Controller\Calculator;

// test 명령어 : vendor/bin/phpunit tests/Unit/CalculatorTest.php
class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp(): void // 각 테스트가 실행되기 전 호출
    {
        $this->calculator = new Calculator();
    }

    protected function tearDown(): void  // 각 테스트가 완료된 후 호출
    {
        $this->calculator = NULL;
    }

    /**
     * @test
     */
    public function testAdd()
    {
        $result = $this->calculator->add(1, 2);
        $this->assertEquals(3, $result); // 올바른지 체크
    }
}
