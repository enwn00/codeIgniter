<?php

namespace App\Service\Board\Dto;

use App\Dto\Board AS BoardEntity;

class Board extends BoardEntity
{
    protected $loginId;
    protected $name;
    protected $nickname;

    /**
     * @return mixed
     */
    public function getLoginId()
    {
        return $this->loginId;
    }

    /**
     * @param mixed $loginId
     */
    public function setLoginId($loginId): void
    {
        $this->loginId = $loginId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }


}
