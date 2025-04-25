<section class="w-100 bg-light">
  <article class="main-banner banner-bic">
    <div class="benner-gradient"></div>
    <p class="ff-pan text-warning fs-lg lh-1s benner-font">
      한편의 이야기에
      <img src="/images/logo.png" class="reverse-img mx-2 img-bright mb-4" width="90px" alt="logo" />
      깡총 뛰어들어보세요.
    </p>
  </article>

  <article class="container py-3 mt-5 border border-danger">
    <?php foreach ($themaList as $key => $value) : ?>
      <div class="card col-3 d-inline-block m-2 align-top text-center" style="min-width: 8rem;">
        <div class="card-header">
          <img src="/images/logo.png" style="height:150px;" alt="<?= $value['title'] ?> 포스터" />
        </div>
        <div class="card-body">
          <h5 class="card-title text-start"><?= $value['title'] ?></h5>
          <p class="card-text overflow-hidden text-start border-bottom" style="height:150px;">
            난이도 <?= $value['level'] ?><br />
            <?= $value['description'] ?>
          </p>
          <a href="/reserve/<?= $value['id'] ?>" class="btn btn-sm btn-primary">예약하기</a>
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
</section>