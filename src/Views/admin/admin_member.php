<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
  멤버 추가하기
</button>

<hr>

<!-- Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">관리자 추가</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/member" method="POST" id="createForm" class="modal-body input-group w-auto">
        <div class="mb-3">
          <p class="mb-1">직급<span class="text-danger ms-1">*</span></p>
          <input class="form-check-input" value="staff" type="radio" name="position" id="position1" checked>
          <label class="form-check-label me-3" for="position1">
            staff
          </label>
          <input class="form-check-input" value="manager" type="radio" name="position" id="position2">
          <label class="form-check-label me-3" for="position2">
            manager
          </label>
          <input class="form-check-input" value="executive" type="radio" name="position" id="position3">
          <label class="form-check-label me-3" for="position3">
            executive
          </label>
          <input class="form-check-input" value="sys_admin" type="radio" name="position" id="position4">
          <label class="form-check-label me-3" for="position4">
            sys_admin
          </label>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">ID<span class="text-danger ms-1">*</span></span>
          <input type="text" class="form-control" placeholder="영문, 숫자만 가능" name="login_id" required />
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">PASSWORD<span class="text-danger ms-1">*</span></span>
          <input type="password" class="form-control" name="pw" required />
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text">전화번호</span>
          <input type="text" class="form-control" placeholder="-제외한 숫자만 입력" name="tell" />
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-sm btn-warning" onclick="checkValues()">추가</button>
      </div>
    </div>
  </div>
</div>

<table class="table table-sm text-center">
  <thead class="align-middle">
    <tr>
      <th class="col-1">no.</th>
      <th class="">ID</th>
      <th class="">직급</th>
      <th class="">전화번호</th>
      <th class="col-1">삭제</th>
    </tr>
  </thead>

  <tbody class="align-middle">
    <?php foreach ($list as $item) : ?>
      <tr>
        <td><?= $item['id'] ?></td>
        <td><?= htmlspecialchars($item['login_id']) ?></td>
        <td><?= $item['position'] ?></td>
        <td><?= $item['tell'] ?></td>
        <td>
          <form action="/admin/member" method="POST" id="member<?= $item['id'] ?>" class="d-none">
            <input type="text" name="_method" value="DELETE" />
            <input type="text" name="id" value="<?= $item['id'] ?>" />
          </form>
          <button class="btn btn-sm btn-danger" onclick="memberDelete(<?= $item['id'] ?>)">삭제</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  // 값 체크해서 submit
  function checkValues() {
    // 빈 값 체크
    const inputs = document.querySelectorAll('input[required]');
    for (const input of inputs) {
      if (!input.value.trim()) {
        // JS toast message
        toastMsgShow("* 표시가 있는 항목에 값을 입력해주세요.");
        return;
      }
    }

    document.querySelector('#createForm').submit();
  }

  // 장르 삭제 delete
  function memberDelete(id) {
    if (confirm("정말 삭제하시겠습니까?")) {
      document.getElementById("member" + id).submit();
    }
  }
</script>