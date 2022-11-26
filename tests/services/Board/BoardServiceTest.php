<?php

use App\Service\Board\BoardService;
use App\Service\Board\DataProvider\BoardDataSeedingProvider;
use App\Service\Board\DataProvider\BoardRedisSeedingProvider;
use App\Tests\Core\CITestCase;

class BoardServiceTest extends CITestCase
{
    private $boardService;

    protected function setUp(): void // 각 테스트가 실행되기 전 호출
    {
        $this->CI = &get_instance();
        $this->boardService = BoardService::getInstance();
    }

    protected function tearDown(): void  // 각 테스트가 완료된 후 호출
    {
        $this->boardService = NULL;
    }

    /**
     * @test
     */
    public function checkSingleton()
    {
        $this->assertEquals(BoardService::getInstance(), $this->boardService);
        $this->assertInstanceOf('App\Service\Board\BoardService', $this->boardService);
    }

    /**
     * @test
     */
    public function 단일_게시판_확인()
    {
        $board = $this->boardService->driver('one', $this->getBoardDataProvider(1))->get();
        $this->assertEquals(1, $board->getBoardId());}

    private function getBoardDataProvider(int $id){
        $redisProvider = (new BoardRedisSeedingProvider())->loadBoard($id);
        if (!$redisProvider->checkBoardEmpty()){
            $dataProvider = $redisProvider;
        } else {
            $dataProvider = (new BoardDataSeedingProvider())->loadBoard($id);
        }

        return $dataProvider;
    }

}
