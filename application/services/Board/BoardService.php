<?php

namespace App\Service\Board;

use App\Service\Board\Provider\BoardProvider;
use App\Service\Board\Provider\BoardListProvider;
use App\Service\Board\Provider\BoardWatchedProvider;

class BoardService
{
    static private $oInstance;

    /**
     * @var BoardProvider
     */
    private $board;

    /**
     * @var BoardListProvider
     */
    private $boardList;

    /**
     * @var BoardWatchedProvider
     */
    private $boardWatched;

    public static function getInstance(): BoardService
    {
        if (empty(self::$oInstance)) {
            self::$oInstance = new self();
        }

        return self::$oInstance;
    }

    public function driver(string $driver, $construct = null)
    {
        try {
            switch ($driver) {
                case 'one':
                    if (empty($this->board)) {
                        $this->board = new BoardProvider($construct);
                    }
                    return $this->board;
                case 'list':
                    if (empty($this->boardList)) {
                        $this->boardList = new BoardListProvider();
                    }

                    return $this->boardList;
                case 'watched':
                    if (empty($this->boardWatched)) {
                        $this->boardWatched = new BoardWatchedProvider();
                    }
                    return $this->boardWatched;
                default:
                    throw new \ArgumentCountError("Not Found driver In Config Array");
            }
        } catch (\Exception $ex) {

        }
    }

    public function getRedisByKeyWildCard(string $redisKey, bool $isAssociative = true){
        return $this->getRedisByKeys($this->getKeysByKeyWildCard($redisKey), $isAssociative);
    }

    private function getKeysByKeyWildCard(string $redisKey) {
        try {
            $redisSlave = $this->redis_lib->redis('slave');

            $iterator = NULL;
            $keys = [];
            while ($iterator !== 0) {
                $arr_keys = $redisSlave->scan($iterator, $redisKey, 1000);
                foreach($arr_keys as $str_key) {
                    array_push($keys, $str_key);
                }
            }

            $this->redis_lib->redis_close();
            unset($redisSlave);

            return $keys;
        } catch(Exception $e){
            return [];
        }
    }

    private function getRedisByKeys(array $redisKey, bool $isAssociative = true){
        try {
            $redisSlave = $this->redis_lib->redis('slave');
            $data = $redisSlave->mget($redisKey);
            if ($data == false) {
                return [];
            }

            foreach ($data as $key => $jsonData){
                $data[$key] = json_decode($jsonData, $isAssociative);
            }

            $this->redis_lib->redis_close();
            unset($redisSlave);

            return $data;
        } catch(Exception $e){
            return [];
        }
    }

    public function setRedis($sKeyName, $aData, $iSetTimeOut = -1){
        try {
            $redisMaster = $this->redis_lib->redis('master');
            $result = $redisMaster->set($sKeyName, json_encode($aData));
            if ($iSetTimeOut > 0) {
                $redisMaster->expire($sKeyName, $iSetTimeOut);
            }
            $this->redis_lib->redis_close();
            unset($redisMaster);
            return $result;
        } catch(Exception $e){
            return false;
        }
    }
}
