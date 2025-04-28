  <article class="container py-3 mt-5 border border-danger">
    <?php foreach ($themaList as $key => $value) : ?>
      <div class="card col-3 d-inline-block m-2 align-top text-center">
        <div class="card-header">
          <img src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>" style="height:150px;" alt="<?= $value['title'] ?> 포스터" />
        </div>
        <div class="card-body">
          <h5 class="card-title text-start"><?= $value['title'] ?></h5>
          <p class="card-text overflow-hidden text-start border-bottom" style="height:150px;">
            난이도 <?= $starHTMLs[$key] ?><br />
            <?= $value['description'] ?>
          </p>
          <a href="/reserve?t=<?= $value['id'] ?>" class="btn btn-sm btn-primary">예약하기</a>
        </div>
      </div>
    <?php endforeach; ?>
  </article>

  <article class="bg-secondary-subtle">
    <ul class="nav-contour nav container py-5 my-5 fs-5 fw-light d-flex justify-content-between align-items-center text-dark">
      <li class="col-6 col-md-3">
        <div class="contour-line d-flex justify-content-center align-items-center">
          <i class="bi bi-clock-history fs-1 me-3 text-secondary"></i>
          15분전 도착
        </div>
      </li>
      <li class="col-6 col-md-3">
        <div class="contour-line d-flex justify-content-center align-items-center">
          <i class="bi bi-volume-mute fs-1 me-3 text-secondary"></i>
          누설 금지
        </div>
      </li>
      <li class="col-6 col-md-3">
        <div class="contour-line d-flex justify-content-center align-items-center">
          <i class="bi bi-telephone-x fs-1 me-3 text-secondary"></i>
          휴대폰 무음
        </div>
      </li>
      <li class="col-6 col-md-3">
        <div class="contour-line d-flex justify-content-center align-items-center">
          <i class="bi bi-bag-x fs-1 me-3 text-secondary"></i>
          파손 주의
        </div>
      </li>
    </ul>
  </article>