<?php
// themaInfo 있으면 수정, 없으면 신규
$isCreate = isset($themaInfo) ? false : true;
?>

<h5 class="text-primary fw-bold mt-4"><?= $isCreate ? "새로운 테마 등록" : "테마 정보" ?></h5>
<form action="/admin/thema" method="POST">
  <?php if (!$isCreate) : ?>
    <!-- update 용 -->
    <input type="hidden" name="id" value="<?= $themaInfo['id'] ?>" />
    <input type="hidden" name="_method" value="PATCH" />
  <?php endif; ?>

  <div class="input-group mb-3">
    <span class="input-group-text">테마명 <span class="text-danger ms-1">*</span></span>
    <input type="text" value="<?= isset($themaInfo['title']) ? $themaInfo['title'] : "" ?>" class="form-control" name="title" placeholder="입력해주세요." required />
  </div>

  <div class="input-group mb-3">
    <label class="input-group-text">난이도 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="level" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 5; $i += 0.5) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['level']) && $i == $themaInfo['level']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <div class="mb-3">
    <div class="input-group">
      <span class="input-group-text">플레이 시간 <span class="text-danger ms-1">*</span></span>
      <input type="number" value="<?= isset($themaInfo['play_time']) ? $themaInfo['play_time'] : null ?>" class="form-control" name="play_time" placeholder="0" min="0" required />
    </div>
    <div class="form-text">분 단위로 입력해주세요.</div>
  </div>

  <div class="input-group mb-3">
    <label class="input-group-text">최소 인원 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="persons_min" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['persons_min']) && $i == $themaInfo['persons_min']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
    <label class="input-group-text">최대 인원 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="persons_max" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 10; $i++) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['persons_max']) && $i == $themaInfo['persons_max']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <div class="input-group mb-3">
    <!-- 장르는 3개까지만 입력 가능 -->
    <?php for ($i = 1; $i < 4; $i++) : ?>
      <label class="input-group-text">장르<?= $i ?></label>
      <select class="form-select" name="gnere<?= $i ?>" id="genre<?= $i ?>" onchange="changeGenreIds();">
        <option value="0">없음</option>
        <?php foreach ($genreList as $key => $value) : ?>
          <option value="<?= $value['id'] ?>" <?= (isset($connectGenres) && count($connectGenres) >= $i && $connectGenres[($i - 1)]['genre_id'] === $value['id']) ? "selected" : "" ?>>
            <?= $value['genre_name'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    <?php endfor; ?>

    <input type="hidden" name="genreIds" id="genreIds" />
  </div>

  <div class="input-group">
    <span class="input-group-text">테마 줄거리 <span class="text-danger ms-1">*</span></span>
    <textarea class="form-control" rows="5" name="description" placeholder="입력해주세요." required><?= isset($themaInfo['description']) ? htmlspecialchars($themaInfo['description']) : "" ?></textarea>
  </div>
</form>

<div class="blcok text-center">
  <?php if ($isCreate) : ?>
    <button class="btn btn-warning my-4 w-auto" onclick="checkValues('create')">생성하기</button>
  <?php else : ?>
    <button class="btn btn-danger my-4 w-auto" onclick="checkValues('update')">수정하기</button>
  <?php endif ?>
  <a class="btn btn-primary my-4 w-auto" href="/admin/thema">목록보기</a>
</div>

<!-- toast message -->
<div class="toast-container top-0 end-0 mt-2 me-2" id="bodyToast">
  <div class="toast" role="alert" aria-atomic="true" data-bs-delay="3000">
    <div class="toast-header">
      <i class="bi bi-bell text-warning"></i>
      <strong class="me-auto">Warning!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      * 표시가 있는 항목에 값을 입력해주세요.
    </div>
  </div>
</div>

<script>
  // 장르 onchange 시 hidden input 값 변경
  function changeGenreIds() {
    let genreIds = [];

    for (let i = 1; i < 4; i++) {
      const genreSelect = document.querySelector(`#genre${i}`);
      if (genreSelect && genreSelect.value !== "0" && genreIds.includes(genreSelect.value) === false) { // "0"은 제외
        genreIds.push(genreSelect.value);
      }
    }

    // hidden 필드에 장르 업데이트
    document.querySelector('#genreIds').value = genreIds.join(',');
  }

  // 값 체크해서 submit
  function checkValues(submitType) {
    // 빈 값 체크
    const inputs = document.querySelectorAll('input[required], textarea[required], select[required]');
    for (const input of inputs) {
      if (!input.value.trim()) {
        // 없으면 toast message 띄우고 종료
        const toastEls = document.querySelectorAll("#bodyToast .toast");
        toastEls.forEach(el => new bootstrap.Toast(el).show());
        return;
      }
    }

    document.querySelector('form').submit();
  }
</script>