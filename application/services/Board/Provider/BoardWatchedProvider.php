<?php

namespace App\Service\Board\Provider;

use App\Helper\CollectionHelper;
use App\Library\CookieManager;

class BoardWatchedProvider
{
    public const RESET_COUNT = 10;

    private $watchedList;
    private $watcherId;

    /**
     * constructor.
     * @throws \Exception
     */
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('Board_model', 'board_model');
        $this->watcherId = CookieManager::getBoardWatched();
    }

    /**
     * @return CollectionHelper
     */
    public function get(): CollectionHelper
    {
        if (empty($this->watchedList)){
            $this->watchedList = (new BoardListProvider)->reformArrayToDto($this->getter());
        }

        return $this->watchedList;
    }

    /**
     * @return array
     */
    private function getter(): array
    {
        return $this->getWatchedInDb();
    }

    /**
     * @return array
     */
    private function getWatchedInDb(): array
    {
        return $this->CI->board_model->getWatched($this->watcherId);
    }

    public function resetWatched(): void
    {
        $this->CI->board_model->deleteWatchedByWatcherId($this->watcherId);
    }

    /**
     * @param int $boardId
     * @return boolean
     */
    public function setWatched(int $boardId): bool
    {
        return $this->CI->board_model->setWatched($this->watcherId, $boardId);
    }
}
