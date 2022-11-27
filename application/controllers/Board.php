<?php

if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use App\Service\Board\BoardService;
use App\Service\Board\DataProvider\BoardDataSeedingProvider;
use App\Service\Board\DataProvider\BoardRedisSeedingProvider;

class Board extends CI_Controller
{
    // http://www.codeigniter.co:8080/board/1
//    public function detail(int $id){
//        $manager = BoardService::getInstance();
//
//        // TODO::DB에 쌓이는 조회수는 Redis의 조회수를 기반으로 10분마다 DB Update 해준다.
//        $board = $manager->driver('one', $this->getBoardDataProvider($id));
//        if ($board->isValid()){
//            // 일반적인 게시판이라면 당연히 조회 수는 히스토리를 쌓아서 한 회원당 한번만 조회수가 증가하게 되어야 하지만, 그냥 단순 조회수 쌓이는 걸로 개발 하겠다.
//            $board->incrementViewCount(+1);
//            // 시청 기록 저장
//            $manager->driver('watched')->setWatched($id);
//        }
//
//        echo '<pre>';
//        print_r($board->get()->toSnakeArray());
//        echo '</pre>';
//        exit;
//    }

    public function detail(int $id){

        try {
            $manager = BoardService::getInstance();

            // TODO::DB에 쌓이는 조회수는 Redis의 조회수를 기반으로 10분마다 DB Update 해준다.
            $board = $manager->driver('one', $this->getBoardDataProvider($id));
            if ($board->isValid()){
                // 일반적인 게시판이라면 당연히 조회 수는 히스토리를 쌓아서 한 회원당 한번만 조회수가 증가하게 되어야 하지만, 그냥 단순 조회수 쌓이는 걸로 개발 하겠다.
                $board->incrementViewCount(+1);
                // 시청 기록 저장
                $manager->driver('watched')->setWatched($id);
            }

            $board = $board->get()->toSnakeArray();
        } catch (Exception $exception) {
            $board = [];
        }

        $aConstruct = [
            'container' =>'board/view',
            'data' => $board
        ];

        $this->load->view('/layout/layout', $aConstruct);

    }

    private function getBoardDataProvider(int $id){
        $redisProvider = (new BoardRedisSeedingProvider())->loadBoard($id);
        if (!$redisProvider->checkBoardEmpty()){
            $dataProvider = $redisProvider;
        } else {
            $dataProvider = (new BoardDataSeedingProvider())->loadBoard($id);
            $redisProvider->set($dataProvider->getBoard());
        }

        return $dataProvider;
    }

    public function list(int $id = 0) {
        try {
            $list = BoardService::getInstance()->driver('list');
            $list->setFixedStart($id); // page navigation last sequence
            $list->removeWatched();

            $list = $list->get()->toSnakeArray();
        } catch (Exception $exception) {
            $list = [];
        }

        $aConstruct = [
            'container' =>'board/list',
            'data' => $list
        ];

        $this->load->view('/layout/layout', $aConstruct);
    }
//
//    // http://www.codeigniter.co:8080/board/watched
//    public function watched(){
//        echo '<pre>';
//        print_r(BoardService::getInstance()
//            ->driver('watched')
//            ->get()
//            ->toSnakeArray());
//        echo '</pre>';
//        exit;
//    }
//
//    // http://www.codeigniter.co:8080/board/delete
//    public function delete(int $id = 0){
//        $result = BoardService::getInstance()
//            ->driver('one', (new App\Service\Board\Dto\Board)
//            ->setBoardId($id))
//            ->delete();
//
//        echo '<pre>';
//        print_r(($result == TRUE) ? "삭제하는데 성공하였습니다." : "삭제하는데 실패하였습니다.");
//        echo '</pre>';
//        exit;
//    }
//
//    public function like(int $id){
//        $board = BoardService::getInstance()
//            ->driver('one', (new App\Service\Board\Dto\Board)
//            ->setBoardId($id));
//
//        echo '<pre>';
//        print_r(($board->incrementLikeCount(+1) == TRUE) ? "추천하는데 성공하였습니다." : "추천하는데 실패하였습니다.");
//        echo '</pre>';
//        exit;
//    }
//
//    public function removelike(int $id){
//        $board = BoardService::getInstance()
//            ->driver('one', (new App\Service\Board\Dto\Board)
//                ->setBoardId($id));
//
//        echo '<pre>';
//        print_r(($board->incrementLikeCount(-1) == TRUE) ? "추천 취소하는데 성공하였습니다." : "추천 취소하는데 실패하였습니다.");
//        echo '</pre>';
//        exit;
//    }
}
