<?php

namespace App\Service\Board\DataProvider;

use App\Service\Board\Dto\Board AS BoardDto;
use App\Service\Board\Contracts\AbstractBoardDataSeedingProvider;
use stdClass;

class BoardRedisSeedingProvider extends AbstractBoardDataSeedingProvider
{
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('Board_redis_model', 'board_redis');
    }

    /**
     * @return stdClass
     */
    public function getter(): stdClass
    {
        return $this->CI->board_redis->get($this->id);
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
     * @param BoardDto $board
     * @return bool
     */
    public function delete(BoardDto $board): bool
    {
        return $this->CI->board_redis->delete($board);
    }

    /**
     * @param BoardDto $board
     * @return bool
     */
    public function put(BoardDto $board): bool
    {
        return $this->CI->board_redis->put($board);
    }

    /**
     * @param BoardDto $board
     * @return bool
     */
    public function set(BoardDto $board): bool
    {
        return $this->CI->board_redis->set($board);
    }

    /**
     * @return BoardDto
     */
    public function getBoardEntity(): BoardDto
    {
        return (new BoardDto)->pull($this->board);
    }
}
