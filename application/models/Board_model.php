<?php

use App\Dto\Board AS BoardEntity;

class Board_model extends MY_Model
{
    public function __construct() {
        parent::__construct();
        // TODO::이렇게 호출하면 밑에서 트랜잭션이 잘 유지되는지 확인 필요
        $this->master->trans_begin();
    }

    /**
     * @param int $id
     * @return stdClass|null
     */
    public function get(int $id): ?stdClass
    {
        $query = "
SELECT A.board_id,
       A.title,
       A.content,
       A.view_count,
       A.like_count,
       A.is_used,
       A.created_datetime,
       B.member_id,
       B.login_id,
       B.name,
       B.nickname
FROM ". BOARD ." AS A
         INNER JOIN ". MEMBER ." AS B
                    ON A.member_id = B.member_id
WHERE A.board_id = ?
LIMIT 1";
        $result = $this->slave->query($query, array($id))->row();

        if($result !== false){
            return $result;
        }

        return null;
    }

    /**
     * @return stdClass|null
     */
    public function getList(): ?array
    {
        $query = "
SELECT A.board_id,
       A.title,
       A.content,
       A.view_count,
       A.like_count,
       A.is_used,
       A.created_datetime,
       B.login_id,
       B.name,
       B.nickname
FROM ". BOARD ." AS A
         INNER JOIN ". MEMBER ." AS B
                    ON A.member_id = B.member_id
ORDER BY A.board_id DESC";
        $result = $this->slave->query($query)->result();

        if($result !== false){
            return $result;
        }else{
            return null;
        }
    }

    /**
     * @param $watcherId
     * @param $boardId
     * @return bool
     */
    public function setWatched($watcherId, $boardId): bool
    {
        // replace Use Test
        return $this->master->replace(BOARD_WATCHED, array(
            'board_id' => $boardId,
            'watcher_id' => $watcherId
        ));
    }

    public function getWatched(string $watcherId): ?array
    {
        $query = "
SELECT B.board_id,
       B.title,
       B.content,
       B.view_count,
       B.like_count,
       B.is_used,
       B.created_datetime,
       C.login_id,
       C.name,
       C.nickname
FROM ". BOARD_WATCHED ." AS A
         INNER JOIN ". BOARD ." AS B
                    ON A.board_id = B.board_id
         INNER JOIN ". MEMBER ." AS C
                    ON B.member_id = C.member_id
WHERE A.watcher_id = ?
ORDER BY A.created_datetime DESC";
        $result = $this->slave->query($query, array($watcherId))->result();

        if($result !== false){
            return $result;
        }else{
            return null;
        }
    }

    public function deleteWatchedByWatcherId(string $watcherId): bool
    {
        return $this->master->delete(BOARD_WATCHED, array('watcher_id' => $watcherId));
    }

    public function set(BoardEntity $board){
        $this->master->where('board_id', $board->getBoardId());
        $this->master->update(BOARD, $board->toSnakeArray());

        if ($this->master->trans_status() === FALSE) {
            $this->master->trans_rollback();
        } else {
            $this->master->trans_commit();
            // TODO::게시판 히스토리 추가
        }

        return $this->master->trans_status();
    }

    public function put(BoardEntity $board){
        $this->master->insert(BOARD, $board->toSnakeArray());

        if ($this->master->trans_status() === FALSE) {
            $this->master->trans_rollback();
        } else {
            $this->master->trans_commit();
            // TODO::게시판 히스토리 추가
        }

        return $this->master->trans_status();
    }

    public function delete(BoardEntity $board)
    {
        $this->master->where('board_id', $board->getBoardId());
        $this->master->delete(BOARD);

        if ($this->master->trans_status() === FALSE) {
            $this->master->trans_rollback();
        } else {
            $this->master->trans_commit();
            // TODO::게시판 히스토리 추가
        }

        return $this->master->trans_status();
    }
}

