<?php

namespace App\Service\Board\Provider;

use App\Service\Board\DataProvider\BoardRedisSeedingProvider;
use App\Service\Board\DataProvider\BoardDataSeedingProvider;
use App\Service\Board\Dto\Board;
use ArgumentCountError;

class BoardProvider
{
    private $dataProvider;

    /**
     * constructor. 의존성주입(DI, Dependency Injection) 방법 사용
     * @param BoardRedisSeedingProvider|BoardDataSeedingProvider $DataProvider
     */
    public function __construct($DataProvider) {
        if (!$DataProvider instanceof BoardRedisSeedingProvider
            && !$DataProvider instanceof BoardDataSeedingProvider) {
            throw new ArgumentCountError("not same instance in CollectionHelper class");
        }

        $this->CI = &get_instance();
        $this->dataProvider = $DataProvider;
    }

    /**
     * @return Board
     */
    public function get(): Board
    {
        return $this->dataProvider->getBoard();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->dataProvider->deleter();
    }

    /**
     * @return bool
     */
    private function setter(): bool
    {
        return $this->dataProvider->setter();
    }

    /**
     * @return bool
     */
    private function putter(): bool
    {
        return $this->dataProvider->putter();
    }

    /**
     * @param int $incrementCount
     * @return void
     */
    public function incrementViewCount(int $incrementCount): bool
    {
        $this->dataProvider->getBoard()->incrementViewCount($incrementCount);
        return $this->setter();
        // TODO::조회 수 히스토리 추가
    }

    /**
     * @param int $incrementCount
     * @return void
     */
    public function incrementLikeCount(int $incrementCount): bool
    {
        $this->dataProvider->getBoard()->incrementLikeCount($incrementCount);
        return $this->setter();
        // TODO::추천 히스토리 추가
        // TODO::추천하기 조작 방지 코드 추가(ex: 1번 밖에 추천 불가능)
    }

    public function isValid(): bool
    {
        return $this->dataProvider->getBoard()->getIsUsed() === 'Y';
    }
}
