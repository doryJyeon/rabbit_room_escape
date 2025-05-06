  <article class="container py-3">
    <?php foreach ($themaJoinList as $key => $value) : ?>
      <div class="row my-5">
        <div class="col-12 col-sm-4 d-inline-block text-center px-0">
          <img class="mw-100 w-100 h-auto" src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>" alt="<?= $value['title'] ?> 포스터" />
        </div>
        <div class="col-12 col-sm-8 d-inline-block">
          <h5 class="text-primary fw-bold pb-2 border-bottom-double">
            <?= $value['title'] ?>
            <span class="fs-6"><?= !empty($value['genre_name']) ? "(" . $value['genre_name'] . ")" : "" ?></span>
          </h5>
          <p class="my-3"><?= nl2br(htmlspecialchars($value['description'])) ?></p>
          <hr />
          <p class="fs-sm">
            <span class="me-3">난이도
              <span class="text-warning mw-1">
                <?= $starHTMLs[$key] ?>
              </span>
            </span>
            <span class="me-3">인원 <?= $value['persons_min'] . "~" . $value['persons_max'] ?>명</span>
            <span class="me-3">시간 <?= $value['play_time'] ?>분</span>
          </p>
          <a href="/reserve?t=<?= $value['id'] ?>" class="btn btn-primary rounded-0">예약하기</a>
        </div>
      </div>
    <?php endforeach; ?>
  </article>