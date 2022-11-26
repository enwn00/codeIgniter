<?php

namespace App\Service\Board\Provider;

use App\Helper\CollectionHelper;
use App\Helper\Traits\SimpleObjectMapper;
use App\Service\Board\Dto\Board;

/**
 * 개인적인 연습 프로젝트기 때문에, 모든 게시판을 한꺼번에 가져와서 연산하는 방법입니다.
 * 당연히 실서버에 운영되어야 하는 프로젝트라면, 조회할때 부분적으로 조회하도록 변경해야하는 점을 참고부탁드립니다.
 */
class BoardListProvider
{
    private $boardList;
    private $watchedList;
    private $length = 20;
    private $fixStartId;
    private $CI;

    /**
     * constructor.
     */
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('Board_model', 'board_model');

        if (empty($this->boardList)){
            $this->setBoardList();
        }
    }

    private function setBoardList(){
        $this->boardList = $this->getter();
    }

    /**
     * @param int|null $length
     * @return CollectionHelper
     */
    public function get(?int $length = 0): CollectionHelper
    {
        if ($length > 0) {
            $this->length = $length;
        }

        $this->reformatByFixedStart();
        $this->boardList->slice($this->length);

        return $this->boardList;
    }

    private function reformatByFixedStart(): void
    {
        if (!empty($this->fixStartId)){
            $this->boardList->filterTheseValues(['boardId' => $this->fixStartId],
                                                ['boardId' => '<=']);
        }
    }

    /**
     * @return CollectionHelper
     */
    private function getter(): CollectionHelper
    {
        $result = $this->getListInDB();
        if (!empty($result))
            return $this->reformArrayToDto($result);

        return $this->reformArrayToDto([]);
    }

    /**
     * @return array
     */
    private function getListInDB(): array
    {
        return $this->CI->board_model->getList();
    }

    /**
     * @param int $id
     */
    public function setFixedStart(int $id): void
    {
        $this->fixStartId = $id ?? null;
    }

    /**
     * @param array $result
     * @return CollectionHelper
     */
    public function reformArrayToDto(array $result): CollectionHelper
    {
        return SimpleObjectMapper::mapEachToCollection($result, Board::class);
    }

    public function removeWatched(): void
    {
        if (empty($this->watchedList)){
            $this->watchedList = (new BoardWatchedProvider());
        }

        if ($this->boardList->count() - $this->watchedList->get()->count() < (int)$this->watchedList::RESET_COUNT){
            $this->watchedList->resetWatched();
        }

        $this->boardList->diff($this->watchedList->get());
    }
}
