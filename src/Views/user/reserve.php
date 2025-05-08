<div class="container">
  <ul class="nav w-100 d-flex align-items-center my-5 text-center fs-7">
    <li class="nav-item w-25 py-2 py-sm-3 bg-dark <?= $step === "1" ? "bg-primary" : "" ?>">
      <span class="text-white">1. 테마 선택</span>
    </li>
    <li class="nav-item w-25 py-2 py-sm-3 bg-dark-2 <?= $step === "2" ? "bg-primary" : "" ?>">
      <span class="text-white">2. 정보 입력</span>
    </li>
    <li class="nav-item w-25 py-2 py-sm-3 bg-dark-3 <?= $step === "3" ? "bg-primary" : "" ?>">
      <span class="text-white">3. 결제하기</span>
    </li>
    <li class="nav-item w-25 py-2 py-sm-3 bg-dark-4 <?= $step === "4" ? "bg-primary" : "" ?>">
      <span class="text-white">4. 예약 완료</span>
    </li>
  </ul>

  <?php if ($step === "1") : ?>
    <!-- 테마 선택 -->
    <article>
      <form action="/reserve?" method="GET" id="searchForm" class="row fs-7">
        <label class="form-label mt-2 mb-3 w-auto col-3">예약 날짜</label>
        <input class="form-control mb-3 w-auto col-3" oninput="searchReserve()" id="dateId" type="date" name="date" value="<?= $date ?>" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+7 days')) ?>" />
        <div class="col-5 d-sm-none"></div>
        <label class="form-label mt-2 mb-3 w-auto col-3">테마 선택</label>
        <select class="form-select mb-3 w-auto col-3" oninput="searchReserve()" name="t" id="tId">
          <option value="0">전체 테마</option>
          <?php foreach ($allThema as $key => $value) : ?>
            <option value="<?= $value['id'] ?>" <?= $value['id'] == $selectThema ? "selected" : "" ?>><?= $value['title'] ?></option>
          <?php endforeach; ?>
        </select>
      </form>

      <div class="my-5 container">
        <?php foreach ($themas as $key => $value) : ?>
          <div class="row my-5">
            <h5 class="text-primary fw-bold px-0"><?= $value['title'] ?></h5>
            <p class="fs-sm border-bottom pb-2 px-0 d-flex align-center">
              <span class="me-3">난이도 :
                <span class="text-warning mw-1">
                  <?= $value["starHTMLs"] ?>
                </span>
              </span>
              <span class="me-3">인원 : <?= $value['persons_min'] . "~" . $value['persons_max'] ?>명</span>
              <span class="me-3">시간 : <?= $value['play_time'] ?>분</span>
            </p>

            <div class="col-12 col-sm-4 d-inline-block text-center px-0 pe-sm-4">
              <img class="mw-300 w-100 h-auto mb-3 mb-sm-0" src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>" alt="<?= $value['title'] ?> 포스터" />
            </div>
            <ul class="col-12 col-sm-8 d-flex flex-wrap align-content-start nav">
              <?php if (empty(array_key_first($themaSchedule[$value['thema_id']]))) : ?>
                <p>예약 가능한 일정이 없습니다.<i class="bi bi-emoji-frown ms-2"></i></p>
              <?php else : ?>
                <?php foreach ($themaSchedule[$value['thema_id']] as $idx => $item) : ?>
                  <?php if ($item['schedule_status'] === "open") : ?>
                    <li class="nav-item bg-primary d-inline-block text-center w-auto px-5 mx-1 mb-2">
                      <form action="/reserve?t=<?= $value['thema_id'] ?>&date=<?= $date ?>&step=2" method="POST">
                        <input type="hidden" name="s" value="<?= $item['schedule_id'] ?>" />
                        <button type="submit" class="bg-primary text-white border-0">
                          <span class="fs-5 mb-0"><?= $item['schedule_time'] ?></span><br />
                          <span class="fs-sm">예약가능</span>
                        </button>
                      </form>
                    </li>
                  <?php else : ?>
                    <li class="nav-item bg-secondary d-inline-block d-inline-block text-white text-center w-auto px-5 mx-1 mb-2">
                      <span class="fs-5 mb-0"><?= $item['schedule_time'] ?></span><br />
                      <span class="fs-xs">예약마감</span>
                    </li>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </ul>
          </div>
        <?php endforeach; ?>
        <?php if (count($themas) === 0) : ?>
          <strong class="text-primary text-center pb-5 d-block">준비된 테마가 없습니다.</strong>
        <?php endif; ?>
      </div>
    </article>

    <script>
      function searchReserve() {
        const form = document.querySelector('#searchForm');
        const date = document.getElementById('dateId').value;
        const thema = document.getElementById('tId').value;
        form.action = `/reserve?date=${date}&t=${thema}`;
        form.submit();
      }
    </script>
  <?php elseif ($step === "2") : ?>
    <!-- 예약자 정보 입력 -->
    <form action="/reserve?t=<?= $thema['id'] ?>&date=<?= $date ?>&step=3" method="POST" class="pb-5" id="scheduleForm">
      <input type="hidden" name="s" value="<?= $schedule['id'] ?>" />
      <table class="table w-100 fs-sm">
        <colgroup>
          <col class="w-25" />
          <col />
        </colgroup>
        <tbody>
          <tr class="border-top">
            <th class="text-center py-3">예약일</th>
            <td class="py-3">
              <?= $schedule['date'] ?>&ensp;<?= $schedule['dayWeek'] ?>요일
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">시간</th>
            <td class="py-3"><?= $schedule['schedule_time'] ?></td>
          </tr>
          <tr>
            <th class="text-center py-3">테마명</th>
            <td class="py-3"><?= $thema['title'] ?></td>
          </tr>
          <tr>
            <th class="text-center py-3">예약자</th>
            <td class="py-3">
              <input type="text" name="name" class="form-control mw-150 fs-sm" required>
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">이메일</th>
            <td class="py-3">
              <input type="email" name="email" class="form-control mw-150 fs-sm" required>
              <p class="fs-xs mb-0">예약 정보가 메일로 발송됩니다. 수신 가능한 메일을 입력해주세요.</p>
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
            <th class="text-center py-3">인원</th>
            <td class="py-3">
              <select class="form-select mw-150 fs-sm" name="persons" onchange="changePerson(this)">
                <?php for ($i = $thema['persons_min']; $i <= $thema['persons_max']; $i++) : ?>
                  <option value="<?= $i ?>"><?= $i ?>명</option>
                <?php endfor; ?>
              </select>
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">테마가격</th>
            <td class="py-3 fs-6 text-primary fw-bold" id="totalPrice">
              <?= $basePrice == 0 ? "고객센터 문의" : $basePrice . "원" ?>
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">결제방식</th>
            <td class="py-3">예약금 결제(20,000원)</td>
          </tr>
        </tbody>
      </table>

      <?php $resetvationInfo = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/policies/reservation_info.txt'); ?>
      <?php $privacyPolicy = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/policies/privacy_policy.txt'); ?>
      <textarea class="w-100 border mt-3 p-2 bg-white fs-sm" rows="4" disabled><?= $resetvationInfo ?></textarea>
      <textarea class="w-100 border my-1 p-2 bg-white fs-sm" rows="4" disabled><?= $privacyPolicy ?></textarea>
      <p class="fs-sm text-center pt-3 pb-4 border-bottom form-check">이용약관 및 개인정보취급방침에 동의합니까?<br />
        <label class="me-5">
          <input id="policyCheck" type="radio" name="privacy_policy" value="true" class="form-check-input"> 동의함
        </label>
        <label>
          <input type="radio" name="privacy_policy" value="false" class="form-check-input"> 동의안함
        </label>
      </p>

      <div class="text-center my-5 pb-5">
        <button class="btn rounded-0 btn-primary fw-bold me-1" type="submit"><i class="bi bi-check-lg me-2"></i>예약하기</button>
        <a class="btn rounded-0 btn-secondary fw-bold" href="/reserve?step=1&date=<?= $schedule['date'] ?>"><i class="bi bi-arrow-left me-2"></i>취소하기</a>
      </div>
    </form>

    <script>
      // 이용약관 동의 체크
      document.getElementById('scheduleForm').addEventListener('submit', function(event) {
        const policyCheck = document.getElementById('policyCheck');
        if (!policyCheck.checked) {
          event.preventDefault(); // 폼 제출 방지
          toastMsgShow('이용약관 및 개인정보취급방침에 동의해야 제출할 수 있습니다.');
        }
      });
      const themaPrice = <?= $price ?>; // 인원수 별 가격

      // 인원수에 따라 가격 변경
      function changePerson(e) {
        const person = e.value;
        const price = themaPrice[person].toLocaleString() + "원" || "고객센터 문의";
        document.querySelector("#totalPrice").innerText = price;
      };

      // 전화번호 4자리 cut
      function cutTellNumber(e) {
        e.value = e.value.replace(/[^0-9]/g, '').slice(0, 4);
      }
    </script>

  <?php elseif ($step === "3") : ?>
    <!-- 예약금 결제 -->
    <form action="/reserve?t=<?= $data['themaId'] ?>&date=<?= $date ?>&step=4" method="POST" class="pb-5">
      <input type="hidden" name="s" value="<?= $data['scheduleId'] ?>" />
      <input type="hidden" name="name" value="<?= $data['name'] ?>" />
      <input type="hidden" name="email" value="<?= $data['email'] ?>" />
      <input type="hidden" name="phone" value="<?= $data['phone'] ?>" />
      <table class="table w-100 fs-sm">
        <colgroup>
          <col class="w-25" />
          <col />
        </colgroup>
        <tbody>
          <tr class="border-top">
            <th class="text-center py-3">테마명</th>
            <td class="py-3"><?= $data['title'] ?></td>
          </tr>
          <tr>
            <th class="text-center py-3">예약일시</th>
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
            <td class="py-3 fs-6 fw-bold"><?= $data['price'] == 0 ? "고객센터 문의" : $data['price'] . "원" ?></td>
          </tr>
          <tr>
            <th class="text-center py-3">예약/결제금</th>
            <td class="py-3 fs-6 text-primary fw-bold">
              20,000원
            </td>
          </tr>
          <tr>
            <th class="text-center py-3">결제방식</th>
            <td class="py-3">무통장 입금</td>
          </tr>
        </tbody>
      </table>

      <div class="text-center my-5 pb-5">
        <button class="btn rounded-0 btn-primary fw-bold" type="submit"><i class="bi bi-check-lg me-2"></i>예약확정</button>
      </div>
    </form>
  <?php elseif ($step === "4") : ?>
    <!-- 예약 완료 -->
    <table class="table w-100 fs-sm">
      <colgroup>
        <col class="w-25" />
        <col />
      </colgroup>
      <tbody>
        <tr class="border-top">
          <th class="text-center py-3">테마명</th>
          <td class="py-3"><?= $data['title'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약일시</th>
          <td class="py-3">
            <?= $data['date'] ?>(<?= $data['dayWeek'] ?>요일)&ensp;<?= $data['time'] ?>
          </td>
        </tr>
        <tr>
          <th class="text-center py-3">인원</th>
          <td class="py-3"><?= $data['persons'] ?>명</td>
        </tr>
        <tr>
          <th class="text-center py-3">테마 가격</th>
          <td class="py-3 fs-6 fw-bold"><?= $data['price'] == 0 ? "고객센터 문의" : $data['price'] . "원" ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약/결제금</th>
          <td class="py-3 fs-6 text-primary fw-bold">
            20,000원
          </td>
        </tr>
        <tr>
          <th class="text-center py-3">결제방식</th>
          <td class="py-3">무통장 입금</td>
        </tr>
        <tr>
          <th class="text-center py-3">예약자</th>
          <td class="py-3"><?= $data['user_name'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">이메일</th>
          <td class="py-3"><?= $data['email'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">연락처</th>
          <td class="py-3"><?= $data['phone'] ?></td>
        </tr>
        <tr>
          <th class="text-center py-3">예약번호</th>
          <td class="py-3"><?= $data['reservedId'] ?><span class="fs-xs text-secondary ms-2">(예약확인 및 취소 시 필요합니다.)</span></td>
        </tr>
      </tbody>
    </table>

    <div class="text-center my-5 pb-5">
      <a href="/" class="btn rounded-0 btn-primary fw-bold"><i class="bi bi-check-lg me-2"></i>메인화면</a>
    </div>
  <?php endif;  ?>
</div>