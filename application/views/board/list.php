<table class="table">
    <thead>
    <tr>
        <th scope="col">No</th>
        <th scope="col">제목</th>
        <th scope="col">내용</th>
        <th scope="col">닉네임</th>
        <th scope="col">등록일자</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $item): ?>
        <tr>
            <th scope="row"><?= $item['board_id'] ?></th>
            <td><a href="/board/<?= $item['board_id'] ?>"><?= $item['title'] ?></a></td>
            <td><?= $item['content'] ?></td>
            <td><?= $item['nickname'] ?></td>
            <td><?= date('Y.m.d', strtotime($item['created_datetime'])) ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
