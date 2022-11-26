<?php

namespace App\Dto;

use App\Helper\Traits\ArrayTrait;
use App\Helper\Traits\DtoTrait;
use App\Helper\Traits\StdObjectMapper;

class Board
{
    use StdObjectMapper;
    use ArrayTrait;
    use DtoTrait;

    protected $boardId;
    protected $title;
    protected $content;
    protected $memberId;
    protected $viewCount;
    protected $likeCount;
    protected $isUsed;
    protected $createdDatetime;

    /**
     * @return mixed
     */
    public function getBoardId()
    {
        return $this->boardId;
    }

    /**
     * @param mixed $boardId
     * @return Board
     */
    public function setBoardId(int $boardId): Board
    {
        $this->boardId = $boardId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Board
     */
    public function setTitle(string $title): Board
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Board
     */
    public function setContent(string $content): Board
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param mixed $memberId
     * @return Board
     */
    public function setMemberId(int $memberId): Board
    {
        $this->memberId = $memberId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param mixed $viewCount
     * @return Board
     */
    public function setViewCount(int $viewCount): Board
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * @param mixed $likeCount
     * @return Board
     */
    public function setLikeCount(int $likeCount): Board
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsUsed()
    {
        return $this->isUsed;
    }

    /**
     * @param mixed $isUsed
     * @return Board
     */
    public function setIsUsed(string $isUsed): Board
    {
        $this->isUsed = $isUsed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedDatetime()
    {
        return $this->createdDatetime;
    }

    /**
     * @param mixed $createdDatetime
     */
    public function setCreatedDatetime($createdDatetime): void
    {
        $this->createdDatetime = $createdDatetime;
    }

    public function incrementViewCount(int $incrementCount)
    {
        $this->viewCount += $incrementCount;
    }

    public function incrementLikeCount(int $incrementCount)
    {
        $this->likeCount += $incrementCount;
    }
}
