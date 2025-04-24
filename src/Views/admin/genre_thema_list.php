<p class="fs-6 text-secondary">
  <span class="text-primary fw-bold"><?= $themaList[0]["genre_name"] ?? null ?></span>
  장르와 연결된 테마 리스트입니다.
</p>

<table class="table table-sm text-center">
  <thead class="align-middle">
    <tr>
      <th class="col-1">id</th>
      <th class="col-2">테마명</th>
      <th>줄거리</th>
      <th class="col-1">난이도</th>
      <th class="col-1">플레이 시간</th>
      <th class="col-1">플레이 인원</th>
      <th class="col-2">생성 시간</th>
    </tr>
  </thead>

  <tbody class="align-middle">
    <?php foreach ($themaList as $thema) : ?>
      <tr>
        <td>
          <a href="/admin/thema/<?= $thema['id'] ?>" class="btn border-secondary btn-sm w-70">
            <?= $thema['id'] ?>
          </a>
        </td>
        <td><?= htmlspecialchars($thema['title']) ?></td>
        <td class="text-start keep-all align-top">
          <div><?= htmlspecialchars(mb_substr($thema['description'], 0, 50)) ?>...</div>
        </td>
        <td><?= $thema['level'] ?></td>
        <td><?= $thema['play_time'] ?></td>
        <td><?= $thema['persons_min'] ?>~<?= $thema['persons_max'] ?></td>
        <td><?= $thema['create_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="blcok text-center">
  <a class="btn btn-primary my-4 w-auto" href="/admin/genre">목록으로 돌아가기</a>
</div>