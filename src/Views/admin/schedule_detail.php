<article class="w-100 mt-2 mb-5">
  <h5 class="text-primary fw-bold">테마별 스케줄 관리(<?= $_GET['date'] ?>)</h5>
  <p class="fs-sm">리셋팅 시간을 생각하며 다음 타임을 잡아주세요.</p>
  <div class="accordion">
    <?php foreach ($themas as $key => $value) : ?>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#accordion<?= $key ?>" aria-expanded="true" aria-controls="accordion<?= $key ?>">
            <?= $value['title'] ?>(<?= $value['play_time'] ?>분)
          </button>
        </h2>
        <div id="accordion<?= $key ?>" class="accordion-collapse collapse show">
          <div class="accordion-body container">
            <!-- 추가 -->
            <div class="row">
              <form action="/admin/schedule" method="POST" class="d-inline-block col-12 col-sm-9 col-md-6 mt-1 mw-300">
                <input type="hidden" name="multiple" value="false" />
                <input type="hidden" name="thema_id" value="<?= $value['thema_id'] ?>" />
                <input type="hidden" name="date" value="<?= $_GET['date'] ?>" />
                <div class="input-group">
                  <select class="form-select" name="hour">
                    <?php for ($i = 9; $i < 24; $i++) : ?>
                      <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                  </select>
                  <select class="form-select" name="minute">
                    <?php for ($i = 0; $i < 6; $i++) : ?>
                      <option value="<?= $i ?>0"><?= $i ?>0</option>
                    <?php endfor; ?>
                  </select>
                  <button class="input-group-text" type="submit">
                    <i class="bi bi-stopwatch me-1"></i>일정 추가
                  </button>
                </div>
              </form>
              <div class="w-auto col-12 col-sm-3 col-md-6 mt-1">
                <button class="btn btn-light border" type="button"
                  data-bs-toggle="modal"
                  data-bs-target="#insertModal"
                  data-thema-id="<?= $value['thema_id'] ?>">
                  <i class="bi bi-card-list me-1"></i>다중 일정 추가
                </button>
              </div>
            </div>

            <hr class="my-2 row" />
            <!-- 추가된 일정 -->
            <div class="row d-flex flex-wrap g-2 mb-2">
              <?php if (!empty(array_key_first($themaSchedule[$value['thema_id']]))) : ?>
                <?php foreach ($themaSchedule[$value['thema_id']] as $idx => $item) : ?>
                  <form action="/admin/schedule" method="POST" id="scheduleForm<?= $item['schedule_id'] ?>" class="d-inline-block mw-155">
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="date" value="<?= $_GET['date'] ?>" />
                    <input type="hidden" name="id" value="<?= $item['schedule_id'] ?>" />
                    <div class="input-group col-4 col-md-1">
                      <input type="text" value="<?= $item['schedule_time'] ?>" class="form-control" readonly>
                      <?php if ($item['schedule_status'] === "open") : ?>
                        <button onclick="deleteSchedule('scheduleForm<?= $item['schedule_id'] ?>')" class="input-group-text btn btn-danger" type="button">
                          <i class="bi bi-trash me-1"></i>삭제
                        </button>
                      <?php else : ?>
                        <button class="input-group-text btn btn-<?= $item['schedule_status'] === "close" ? "success" : "secondary" ?>" type="button">
                          <i class="bi bi-calendar-check me-1"></i> <?= $item['schedule_status'] === "close" ? "예약됨" : "종료" ?>
                        </button>
                      <?php endif; ?>
                    </div>
                  </form>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- multiple insert Modal -->
  <div class="modal fade" id="insertModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">다중 일정 추가</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="/admin/schedule" method="POST">
            <input type="hidden" name="date" value="<?= $_GET['date'] ?>">
            <input type="hidden" name="multiple" value="true">
            <input type="hidden" name="thema_id" id="insertThemaId" />

            <p class="fs-sm mb-0">아래 예시와 같이 ','로 구분해서 넣어주세요.<br />예시)11:30,13:00,14:50</p>
            <!-- textarea로 일정 입력 -->
            <textarea name="times" class="form-control" placeholder="예시)11:30,13:00,14:50" rows="4"></textarea>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">추가</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    const insertModal = document.getElementById('insertModal');

    // multiple insert modal open 시 thema-id 넣기
    insertModal.addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget; // 모달 open 버튼
      const themaId = button.getAttribute('data-thema-id');
      const hiddenInput = insertModal.querySelector('#insertThemaId');
      hiddenInput.value = themaId;
    });

    // 시간 삭제
    const deleteSchedule = scheduleId => {
      if (confirm("정말 삭제하시겠습니까?")) {
        document.querySelector(`#${scheduleId}`).submit();
      }
      return;
    }
  </script>