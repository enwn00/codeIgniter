<?php

use PHPUnit\Framework\TestCase;

// test 명령어 : vendor/bin/phpunit tests/Unit/CalculaoterTest_TestDouble.php
class CalculaoterTest_TestDouble extends TestCase
{
    /**
     * @test
     */
    public function testWithStub()
    {
        // Create a stub for the Calculator class.
        $calculator = $this->getMockBuilder('App\Controller\Calculator')
            ->getMock();

        // Configure the stub.
        $calculator->expects($this->any())
            ->method('add')
            ->will($this->returnValue(6));

        $this->assertEquals(6, $calculator->add(100,100));
    }
}
