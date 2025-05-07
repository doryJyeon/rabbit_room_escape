<?php
// themaInfo 있으면 수정, 없으면 신규
$isCreate = isset($themaInfo) ? false : true;
?>

<h5 class="text-primary fw-bold mt-4 container"><?= $isCreate ? "새로운 테마 등록" : "테마 정보" ?></h5>
<form action="/admin/thema" class="container fs-7" method="POST">
  <?php if (!$isCreate) : ?>
    <!-- update 용 -->
    <input type="hidden" name="id" value="<?= $themaInfo['id'] ?>" />
    <input type="hidden" name="_method" value="PATCH" />
  <?php endif; ?>

  <div class="input-group mb-3">
    <span class="input-group-text fs-7">테마명 <span class="text-danger ms-1">*</span></span>
    <input type="text" value="<?= isset($themaInfo['title']) ? $themaInfo['title'] : "" ?>" class="form-control" name="title" placeholder="입력해주세요." required />
  </div>

  <div class="input-group mb-3">
    <label class="input-group-text fs-7">난이도 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="level" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 5; $i += 0.5) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['level']) && $i == $themaInfo['level']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <div class="input-group mb-3">
    <!-- 장르는 3개까지만 입력 가능 -->
    <?php for ($i = 1; $i < 4; $i++) : ?>
      <label class="input-group-text fs-7">장르<?= $i ?></label>
      <select class="form-select fs-7 w-auto" name="gnere<?= $i ?>" id="genre<?= $i ?>" onchange="changeGenreIds();">
        <option value="0">없음</option>
        <?php foreach ($genreList as $key => $value) : ?>
          <option value="<?= $value['id'] ?>" <?= (isset($connectGenres) && count($connectGenres) >= $i && $connectGenres[($i - 1)]['genre_id'] === $value['id']) ? "selected" : "" ?>>
            <?= $value['genre_name'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    <?php endfor; ?>
  </div>
  <input type="hidden" name="genreIds" id="genreIds" />

  <div class="mb-3">
    <div class="input-group">
      <span class="input-group-text fs-7">플레이 시간 <span class="text-danger ms-1">*</span></span>
      <input type="number" value="<?= isset($themaInfo['play_time']) ? $themaInfo['play_time'] : null ?>" class="form-control" name="play_time" placeholder="0" min="0" required />
    </div>
    <div class="form-text">분 단위로 입력해주세요.</div>
  </div>

  <div class="input-group mb-3">
    <span class="input-group-text fs-7">테마 줄거리 <span class="text-danger ms-1">*</span></span>
    <textarea class="form-control fs-7" rows="5" name="description" placeholder="입력해주세요." required><?= isset($themaInfo['description']) ? htmlspecialchars($themaInfo['description']) : "" ?></textarea>
  </div>

  <div class="input-group mb-3">
    <label class="input-group-text fs-7">최소 인원 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="persons_min" id="personsMin" onchange="updatePriceFields()" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['persons_min']) && $i == $themaInfo['persons_min']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
    <label class="input-group-text fs-7">최대 인원 <span class="text-danger ms-1">*</span></label>
    <select class="form-select" name="persons_max" id="personsMax" onchange="updatePriceFields()" required>
      <option hidden>선택해주세요.</option>
      <?php for ($i = 1; $i <= 10; $i++) : ?>
        <option value="<?= $i ?>" <?= (isset($themaInfo['persons_max']) && $i == $themaInfo['persons_max']) ? "selected" : "" ?>><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <strong class="col-12">인원 별 결제 금액<span class="text-danger ms-1">*</span></strong>
  <div class="row" id="personsPrice">
    <?php if (!$isCreate && isset($themaPrice)) : ?>
      <?php foreach ($themaPrice as $key => $value) : ?>
        <?php $j = $value['person']; ?>
        <div class="col-12 col-md-6 col-lg-4 personPrices" id="personPrice<?= $j ?>">
          <div class="input-group mb-1">
            <label class="input-group-text fs-7"><?= $j ?>명</label>
            <input type="hidden" name="price<?= $j ?>person" value="<?= $j ?>" />
            <input type="text" value="<?= number_format($value['price']) ?>" oninput="formatNumber(this)" class="form-control" name="price<?= $j ?>" id="price<?= $j ?>" placeholder="총액을 입력해주세요." required />
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="form-text col-12 mb-3" id="priceMent">총 결제 금액을 선택해주세요.</div>
</form>

<div class="blcok text-center">
  <?php if ($isCreate) : ?>
    <button class="btn btn-warning my-4 w-auto" onclick="checkValues('create')">생성하기</button>
  <?php else : ?>
    <button class="btn btn-danger my-4 w-auto" onclick="checkValues('update')">수정하기</button>
  <?php endif ?>
  <a class="btn btn-primary my-4 w-auto" href="/admin/thema">목록보기</a>
</div>

<script>
  // 인원별 가격 input 탬플릿
  const priceTemplate = (num, value = "") => (`
    <div class="col-12 col-md-6 col-lg-4 personPrices" id="personPrice${num}">
      <div class="input-group mb-1">
        <label class="input-group-text">${num}명</label>
        <input type="hidden" name="price${num}person" value="${num}" />
        <input type="text" value="${value}" oninput="formatNumber(this)" class="form-control" name="price${num}" id="price${num}" placeholder="총액을 입력해주세요." required />
      </div>
    </div>
  `);

  // 기존 가격 필드와의 비교 및 업데이트
  function updatePriceFields() {
    const minPersons = parseInt(document.querySelector('#personsMin').value);
    const maxPersons = parseInt(document.querySelector('#personsMax').value);
    const priceContainer = document.querySelector('#personsPrice');

    // 기존에 있는 가격 입력 필드들을 가져옴
    const priceFields = priceContainer.querySelectorAll('.personPrices');

    let existMin = parseInt(priceFields[0]?.getAttribute("id").replace(/\D/g, '') || 2); // 기본이 2인
    let existMax = parseInt(priceFields[priceFields.length - 1]?.getAttribute("id").replace(/\D/g, '') || 2);
    let newHtml = "";

    // 현재 보다 적은지 체크
    if (existMin > minPersons) {
      // (변경된 max 값이 현재 최소보다 작으면) 변경된 max를 기준으로 실행
      const forMax = (existMin < maxPersons) ? existMin : maxPersons;
      for (let i = minPersons; i < forMax; i++) {
        newHtml += priceTemplate(i);
      }
    } else {
      // (변경된 min 값이 최소보다 크면) 변경 min = 현재 min 으로 기준 변경
      existMin = minPersons;
    }
    // (변경된 max 값이 현재 min과 같거나 더 크면) 기존 + new max input 추가
    if (existMin <= maxPersons) {
      // 현재 ~ 많아졌을 때 필드 추가
      for (let i = existMin; i <= maxPersons; i++) {
        const exitPrice = document.querySelector(`#price${i}`);
        if (exitPrice) {
          newHtml += priceTemplate(i, exitPrice.value);
        } else {
          newHtml += priceTemplate(i);
        }
      }
    }
    priceContainer.innerHTML = newHtml;
  }

  // price input 컴마 찍기
  function formatNumber(input) {
    let value = input.value.replace(/[^\d]/g, ''); // 숫자만 남기기
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

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
        // JS toast message
        toastMsgShow("* 표시가 있는 항목에 값을 입력해주세요.");
        return;
      }
    }

    document.querySelector('form').submit();
  }
</script>