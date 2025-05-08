  <article class="container py-3">
    <?php foreach ($themaJoinList as $key => $value) : ?>
      <div class="row my-5 pb-4 pb-sm-0">
        <div class="col-12 col-sm-4 mb-3 mb-sm-0 d-inline-block text-center px-0">
          <img class="mw-300 w-100 h-auto" src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>" alt="<?= $value['title'] ?> 포스터" />
        </div>
        <div class="col-12 col-sm-8 d-inline-block">
          <h5 class="text-primary fw-bold pb-2 border-bottom-double">
            <?= $value['title'] ?>
            <span class="fs-6"><?= !empty($value['genre_name']) ? "(" . $value['genre_name'] . ")" : "" ?></span>
          </h5>
          <p class="my-3 fs-7"><?= nl2br(htmlspecialchars($value['description'])) ?></p>
          <hr />
          <p class="fs-sm">
            <span class="me-2 me-md-3">난이도
              <span class="text-warning mw-1">
                <?= $starHTMLs[$key] ?>
              </span>
            </span>
            <span class="me-2 me-md-3">인원 <?= $value['persons_min'] . "~" . $value['persons_max'] ?>명</span>
            <span>시간 <?= $value['play_time'] ?>분</span>
          </p>
          <a href="/reserve?t=<?= $value['id'] ?>" class="btn btn-md-sm btn-primary rounded-0">예약하기</a>
        </div>
      </div>
    <?php endforeach; ?>
    <?php if (count($themaJoinList) === 0) : ?>
      <div class="row my-5 pb-5 text-center">
        <h5 class="text-primary fw-bold">
          테마 준비중입니다.
        </h5>
      </div>
    <?php endif; ?>
  </article>