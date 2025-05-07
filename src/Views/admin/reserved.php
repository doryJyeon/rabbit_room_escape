<!-- 일자, 테마 검색 -->
<form action="/reserve?" method="GET" id="searchForm" class="fs-7">
  <label class="form-label me-4 mt-1 w-auto d-inline-block">예약 날짜
    <input class="form-control w-auto d-inline-block" oninput="searchReserve()" id="dateId" type="date" name="date" value="<?= $date ?>" />
  </label>
  <label class="form-label mt-1 w-auto d-inline-block">테마 선택
    <select class="form-select w-auto d-inline-block" oninput="searchReserve()" name="t" id="tId">
      <option value="0">전체 테마</option>
      <?php foreach ($allThema as $key => $value) : ?>
        <option value="<?= $value['id'] ?>" <?= $value['id'] == $themaId ? "selected" : "" ?>><?= $value['title'] ?></option>
      <?php endforeach; ?>
    </select>
  </label>
</form>

<hr>

<!-- change status Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">예약 상태 변경</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/admin/reserved" method="POST" id="updateForm" class="modal-body input-group w-auto">
        <div class="w-100 fw-bold text-secondary fs-sm border-bottom mb-2 pb-2">
          <p id="modalDate" class="mb-1"></p>
          <p id="modalTitle" class="mb-1"></p>
          <p id="modalName" class="mb-0"></p>
        </div>
        <input type="hidden" name="_method" value="PATCH" />
        <input type="hidden" name="rId" id="modalRID" value="0" />
        <div class="mb-3">
          <p class="mb-2 fw-bold">예약 상태</p>
          <label class="form-check-label w-100 mb-2">
            <input class="form-check-input" value="pending" type="radio" name="status" id="pending_status" />
            신청
          </label>
          <label class="form-check-label w-100 mb-2">
            <input class="form-check-input" value="confirmed" type="radio" name="status" id="confirmed_status" />
            확정 (예약금 입금 완료)
          </label>
          <label class="form-check-label w-100 mb-2">
            <input class="form-check-input" value="canceled" type="radio" name="status" id="canceled_status" />
            취소 (예약금 미입금 / 예약자 요청 취소)
          </label>
          <label class="form-check-label w-100 mb-2">
            <input class="form-check-input" value="denied" type="radio" name="status" id="denied_status" />
            거부 (블랙 리스트 / 관리자 권한 취소)
          </label>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">닫기</button>
        <button type="submit" form="updateForm" class="btn btn-sm btn-warning">변경</button>
      </div>
    </div>
  </div>
</div>

<!-- 예약 내역 list -->
<table class="table table-sm text-center container fs-7 keep-all">
  <thead class="align-middle">
    <tr>
      <th class="col-1">no.</th>
      <th class="col-2">일시</th>
      <th class="">테마</th>
      <th class="col-1">예약자</th>
      <th class="">전화번호</th>
      <th class="col-1">인원</th>
      <th class="col-1">가격</th>
      <th class="col-1">상태</th>
    </tr>
  </thead>

  <tbody class="align-middle">
    <?php foreach ($list as $key => $value) : ?>
      <tr>
        <td><?= $value['reservedId'] ?></td>
        <td><?= $value['date'] . "<br/>" . $value['time'] ?></td>
        <td><?= $value['title'] ?></td>
        <td><?= $value['user_name'] ?></td>
        <td><?= $value['phone'] ?></td>
        <td><?= $value['persons'] ?></td>
        <td><?= $value['price'] ?></td>
        <td>
          <button
            class="btn btn-<?= $value['btnColor'] ?>"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#changeStatusModal"
            data-id="<?= $value['reservedId'] ?>"
            data-date="<?= $value['date'] ?> <?= $value['time'] ?>"
            data-title="<?= $value['title'] ?>"
            data-name="<?= $value['user_name'] ?>"
            data-status="<?= $value['status'] ?>">
            <?= $value['statusKo'] ?>
          </button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  // modal open -> 데이터 입력
  document.getElementById('changeStatusModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;

    document.getElementById('modalRID').value = button.dataset.id;
    document.getElementById('modalDate').textContent = button.dataset.date;
    document.getElementById('modalTitle').textContent = `테마: ${button.dataset.title}`;
    document.getElementById('modalName').textContent = `예약자: ${button.dataset.name}`;

    // 예약 상태 라디오 체크
    const status = button.dataset.status;
    if (status) {
      const radio = document.getElementById(`${status}_status`);
      if (radio) radio.checked = true;
    }
  });

  // 날짜, 테마 검색
  function searchReserve() {
    const form = document.querySelector('#searchForm');
    const date = document.getElementById('dateId').value;
    const thema = document.getElementById('tId').value;
    form.action = `/admin/reserved?date=${date}&t=${thema}`;
    form.submit();
  }
</script>