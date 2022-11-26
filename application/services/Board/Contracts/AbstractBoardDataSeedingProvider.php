<?php

namespace App\Service\Board\Contracts;

use App\Helper\Traits\SimpleObjectMapper;
use App\Service\Board\Dto\Board;
use stdClass;

abstract class AbstractBoardDataSeedingProvider implements BoardDataSeedingProvider
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Board
     */
    protected $board;

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Board $board
     * @return void
     */
    public function setBoard(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param int $id
     * @return AbstractBoardDataSeedingProvider
     */
    public function loadBoard(int $id): AbstractBoardDataSeedingProvider
    {
        $this->setId($id);
        $this->setBoard($this->reformArrayToDto($this->getter()));
        return $this;
    }

    /**
     * @param stdClass $result
     * @return Board
     */
    public function reformArrayToDto(stdClass $result): Board
    {
        return SimpleObjectMapper::map($result, Board::class);
    }

    /**
     * @return bool
     */
    public function checkBoardEmpty(): bool
    {
        return empty($this->getBoard()->getBoardId());
    }

}
