<?php

use App\Tests\Core\CITestCase;

class BoardModelTest extends CITestCase
{
    protected function setUp(): void
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Board_model', 'board_model');
    }

    protected function tearDown(): void
    {
    }

    /**
     * @test
     */
    public function 단일_게시판_확인()
    {
        $board = $this->CI->board_model->get(1);
        $this->assertEquals(1, $board->board_id);
    }
}
