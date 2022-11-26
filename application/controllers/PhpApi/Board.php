<?php

if ( ! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use App\Service\Board\BoardService;
use App\Dto\ApiResponse;

class Board extends CI_Controller
{

    // http://www.ci-project.co:8080/phpApi/Board/list
    public function list(){
        $id = (int)$this->input->get("id");
        $response = new ApiResponse();

        try {
            $list = BoardService::getInstance()->driver('list');
            $list->setFixedStart($id); // page navigation last sequence
            $list->removeWatched();

            echo $response
                ->setData([ 'list' => $list->get()->toSnakeArray() ])
                ->successResponse();

        } catch (Exception $ex) {
            echo $response->setMsg(($ex->getMessage()) ?: null)->failResponse();
        }
    }
}
