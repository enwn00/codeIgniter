<?php

use PHPUnit\Framework\TestCase;
use App\Controller\PriceCalculator;

// test 명령어 : vendor/bin/phpunit application/tests/Unit/PriceCalculatorTest.php
class PriceCalculatorTest extends TestCase
{
    private $PriceCalculator;

    public function setUp(): void
    {
        parent::setUp();
        $this->PriceCalculator = new PriceCalculator();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->PriceCalculator);
    }

    /*
 이 테스트는 개체가 인스턴스화될 수 있는지 확인합니다. 일부에서는 이것이 불필요하다고 주장할 수 있지만 TDD의 관점에서 우리는 이러한 간단한 테스트를 하고 싶습니다. 이 테스트를 통과하면 자연스럽게 실제 동작을 테스트하는 것으로 넘어갈 수 있습니다.

    */

    /**
     * @test
     */
    public function object_can_created()
    {
        $priceCalculator = new PriceCalculator();
        $this->assertInstanceOf('App\Controller\PriceCalculator', $priceCalculator);
    }

    /**
     * @test
     */
    public function should_sum_price()
    {
        $items = [
            ['price' => 100],
            ['price' => 200],
        ];

        $result = $this->PriceCalculator->total($items);
        $this->assertEquals(300, $result);
    }

    /**
     * @test
     */
    public function empty_items_should_return_zero()
    {
        $items = [];
        $result = $this->PriceCalculator->total($items);
        $this->assertEquals(0, $result);
    }
}
