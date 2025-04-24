<div class="d-flex justify-content-end align-items-center gap-2 w-auto mb-3">
  <form action="/admin/genre" method="POST" id="createForm" class="collapse input-group w-auto">
    <input type="text" name="genre_name" class="form-control w-auto" placeholder="새로운 장르 입력" required autocomplete="off">
    <button class="btn btn-warning" type="submit" id="createBtn">추가</button>
  </form>
  <button class="btn btn-primary w-auto" type="button" data-bs-toggle="collapse" data-bs-target="#createForm">
    장르 추가하기
  </button>
</div>

<p class="fs-6 text-secondary opacity-50">id를 클릭하면 관련 테마를 확인 할 수 있습니다.</p>

<table class="table table-sm text-center">
  <thead class="align-middle">
    <tr>
      <th class="col-2">id</th>
      <th class="">장르</th>
      <th class="">생성 시간</th>
      <th class="col-1">삭제</th>
    </tr>
  </thead>

  <tbody class="align-middle">
    <?php foreach ($getList as $item) : ?>
      <tr>
        <td>
          <a href="/admin/genre/<?= $item['id'] ?>" class="btn btn-light border btn-sm w-70">
            <?= $item['id'] ?>
          </a>
        </td>
        <td><?= htmlspecialchars($item['genre_name']) ?></td>
        <td><?= $item['create_at'] ?></td>
        <td>
          <form action="/admin/genre" method="POST" id="genreId<?= $item['id'] ?>" class="d-none">
            <input type="text" name="_method" value="DELETE" />
            <input type="text" name="id" value="<?= $item['id'] ?>" />
          </form>
          <button class="btn btn-sm btn-danger" onclick="genreDelete(<?= $item['id'] ?>)">삭제</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  // 장르 삭제 delete
  function genreDelete(id) {
    if (confirm("정말 삭제하시겠습니까?\n연결된 테마가 없는 장르만 삭제 가능합니다.")) {
      document.getElementById("genreId" + id).submit();
    }
  }
</script>