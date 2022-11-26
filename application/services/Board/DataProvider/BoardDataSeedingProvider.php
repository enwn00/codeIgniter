<?php

namespace App\Service\Board\DataProvider;

use App\Dto\Board AS BoardEntity;
use App\Service\Board\Contracts\AbstractBoardDataSeedingProvider;
use stdClass;

class BoardDataSeedingProvider extends AbstractBoardDataSeedingProvider
{
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('Board_model', 'board_model');
    }

    /**
     * @return stdClass
     */
    public function getter(): stdClass
    {
        return $this->CI->board_model->get($this->id);
    }

    /**
     * @return bool
     */
    public function deleter(): bool
    {
        return $this->delete($this->getBoardEntity());
    }

    /**
     * @return bool
     */
    public function putter(): bool
    {
        return $this->put($this->getBoardEntity());
    }

    /**
     * @return bool
     */
    public function setter(): bool
    {
        return $this->set($this->getBoardEntity());
    }

    /**
     * @param BoardEntity $board
     * @return bool
     */
    public function delete(BoardEntity $board): bool
    {
        return $this->CI->board_model->delete($board);
    }

    /**
     * @param BoardEntity $board
     * @return bool
     */
    public function put(BoardEntity $board): bool
    {
        return $this->CI->board_model->put($board);
    }

    /**
     * @param BoardEntity $board
     * @return bool
     */
    public function set(BoardEntity $board): bool
    {
        return $this->CI->board_model->set($board);
    }

    /**
     * @return BoardEntity
     */
    public function getBoardEntity(): BoardEntity
    {
        return (new BoardEntity)->pull($this->board);
    }
}
