<?php

namespace App\Service\Board\Contracts;

use App\Dto\Board as BoardEntity;
use App\Service\Board\Dto\Board AS BoardDto;
use App\Service\Board\Dto\Board;
use stdClass;

interface BoardDataSeedingProvider
{
    /**
     * @param int $id
     */
    public function setId(int $id);

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     */
    public function loadBoard(int $id);

    /**
     * @param Board $board
     */
    public function setBoard(Board $board);

    /**
     * @return Board
     */
    public function getBoard(): Board;

    /**
     * @return stdClass
     */
    public function getter(): stdClass;

    /**
     * @return bool
     */
    public function deleter(): bool;

    /**
     * @return bool
     */
    public function putter(): bool;

    /**
     * @return bool
     */
    public function setter(): bool;

    /**
     * @param stdClass $result
     * @return Board
     */
    public function reformArrayToDto(stdClass $result): Board;

    /**
     * @return BoardDto | BoardEntity
     */
    public function getBoardEntity();

    /**
     * @return bool
     */
    public function checkBoardEmpty(): bool;
}
