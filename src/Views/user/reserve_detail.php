<div class="container">
  <?php if (empty($name)) : ?>
    <!-- 예약자 정보 확인 -->
    <form action="/reserve_detail" method="POST" class="pb-5 mt-5">
      <input type="hidden" name="_method" value="GET" />
      <table class="table w-100 fs-sm">
        <colgroup>
          <col class="w-25" />
          <col />
        </colgroup>
        <tbody>
          <tr class="border-top">
            <th class="text-center py-3">예약자명</th>
            <td class="py-3">
              <input type="text" name="name" class="form-control form-control-sm mw-200 fs-sm" required>
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">연락처</th>
            <td class="py-3">
              <div class="input-group">
                <select class="form-select mw-80 fs-sm" name="phone1">
                  <option value="010">010</option>
                  <option value="011">011</option>
                  <option value="016">016</option>
                  <option value="017">017</option>
                  <option value="018">018</option>
                  <option value="019">019</option>
                </select>
                <input type="text" name="phone2" oninput="cutTellNumber(this)" class="form-control mw-80 fs-sm text-center" required />
                <input type="text" name="phone3" oninput="cutTellNumber(this)" class="form-control mw-80 fs-sm text-center" required />
              </div>
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">예약번호</th>
            <td class="py-3">
              <input type="text" name="rId" class="form-control form-control-sm mw-200 fs-sm" required>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="text-center my-5 pb-5">
        <button class="btn rounded-0 btn-primary fw-bold me-1" type="submit"><i class="bi bi-check-lg me-2"></i>예약확인</button>
      </div>
    </form>

    <script>
      // 전화번호 4자리 cut
      function cutTellNumber(e) {
        e.value = e.value.replace(/[^0-9]/g, '').slice(0, 4);
      }
    </script>

  <?php else : ?>
    <!-- 예약 내역 -->
    <table class="table w-100 fs-sm my-5">
      <colgroup>
        <col class="w-25" />
        <col />
      </colgroup>
      <tbody>
        <tr class="border-top">
          <th class="text-center py-3">예약 상태</th>
          <td class="py-3">예약 <?= $data['statusKo'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">테마명</th>
          <td class="py-3"><?= $data['title'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약 일시</th>
          <td class="py-3">
            <?= $data['date'] ?>(<?= $data['dayWeek'] ?>요일)&ensp;<?= $data['time'] ?>
          </td>
        </tr>
        <tr>
          <th class="text-center py-3">인원</th>
          <td class="py-3">
            <?= $data['persons'] ?>명
            <input type="hidden" name="persons" value="<?= $data['persons'] ?>" />
          </td>
        </tr>
        <tr>
          <th class="text-center py-3">테마 가격</th>
          <td class="py-3"><?= $data['price'] == 0 ? "고객센터 문의" : $data['price'] . "원" ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약자</th>
          <td class="py-3"><?= $data['user_name'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">연락처</th>
          <td class="py-3"><?= $data['phone'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약/결제금</th>
          <td class="py-3"><?= $data['isConfirmed'] ? "20,000원" : "0" ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">결제방식</th>
          <td class="py-3"><?= $data['isConfirmed'] ? "현장 결제" : "무통장입금" ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">남은요금</th>
          <td class="py-3"><?= $data['leftPrice'] > 0 ? $data['leftPrice'] . "원" : "고객센터 문의" ?></td>
        </tr>
      </tbody>
    </table>

    <p class="fs-sm text-secondary text-center mb-5">** 예약 <?= $data['statusKo'] ?> <?= $data['updated_at'] ?> **</p>
    <div class="mb-5 pb-5 d-flex gap-2 justify-content-center">
      <a href="/" class="btn rounded-0 btn-secondary fw-bold"><i class="bi bi-arrow-left me-2"></i>메인화면</a>
      <?php if ($data['status'] !== "canceled" && $data['status'] !== "denied") : ?>
        <form action="/reserve_detail" method="POST">
          <button type="submit" class="btn rounded-0 btn-secondary fw-bold btn-danger"><i class="bi bi-x-lg me-2"></i>취소요청</button>
          <input type="hidden" name="rId" value="<?= $data['reservedId'] ?>" />
          <input type="hidden" name="sId" value="<?= $data['scheduleId'] ?>" />
          <input type="hidden" name="_method" value="PATCH" />
        </form>
      <?php endif; ?>
    </div>
  <?php endif;  ?>
</div>