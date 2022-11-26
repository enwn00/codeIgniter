<?php

use App\Dto\Board as BoardEntity;
use App\Library\Cache\CacheManager;

class Board_redis_model extends CI_Model
{
    public const REDIS_KEY = 'board';

    public function __construct() {
        parent::__construct();
    }

    public function get(int $id): stdClass
    {
        $data = (CacheManager::getInstance()->driver('redis'))
            ->get(self::REDIS_KEY . ":" . $id);

        if (empty($data)){
            return new stdClass;
        }

        return json_decode($data);
    }

    public function delete()
    {

    }

    public function put()
    {

    }

    public function set(BoardEntity $board): bool
    {
        return (CacheManager::getInstance()->driver('redis'))
            ->set(self::REDIS_KEY . ":" . $board->getBoardId(), json_encode($board->toSnakeArray()));
    }
}

