<article class="container py-3 mt-5">
  <!-- pc용 -->
  <div class="row d-none d-lg-flex">
    <div class="col-1 position-relative p-0">
      <button class="position-absolute top-0 bottom-0 p-0 border-0 bg-none text-secondary" type="button" data-bs-target="#carouselMainPc" data-bs-slide="prev">
        <i class="bi bi-chevron-compact-left w-100 fs-1" aria-hidden="true"></i>
        <span class="visually-hidden">Previous</span>
      </button>
    </div>
    <div id="carouselMainPc" class="carousel slide col-10 p-0">
      <div class="carousel-inner">
        <?php $chunkThemaList = array_chunk($themaList, 2); ?>
        <?php foreach ($chunkThemaList as $key => $chunk) : ?>
          <div class="carousel-item <?= $key === 0 ? "active" : "" ?>">
            <div class="d-md-flex">
              <?php foreach ($chunk as $idx => $value) : ?>
                <div class="d-flex w-100 w-md-50" style="height:230px;">
                  <img
                    class="w-auto h-100 pe-3"
                    src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>"
                    alt="<?= $value['title'] ?> 포스터" />
                  <div class="d-flex flex-column pe-5px">
                    <h5 class="fs-5 fw-bold text-dark"><?= $value['title'] ?></h5>
                    <p class="bg-body-secondary px-2 py-1 rounded-5 fs-xs fw-bold text-secondary d-inline-block mb-2 w-auto me-auto">난이도<?= $starHTMLs[$key] ?></p>
                    <p class="three-line keep-all fs-sm">
                      <?= $value['description'] ?>
                    </p>
                    <a href="/reserve?t=<?= $value['id'] ?>" class="btn fs-xs btn-primary rounded-0 mt-auto me-auto d-inline-block w-auto px-5 py-2 fw-bold">예약하기</a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if (count($chunkThemaList) === 0) : ?>
          <div class="carousel-item active">
            <div class="d-md-flex">
              <div class="d-flex w-100 w-md-50" style="height:230px;">
                <img class="w-auto h-100 pe-3" src="/images/posters/sample.jpg" />
                <div class="d-flex flex-column pe-5px">
                  <h5 class="fs-5 fw-bold text-dark">테마 준비중</h5>
                  <p class="three-line keep-all fs-sm">
                    아직 오픈된 테마가 없습니다.
                  </p>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-1 position-relative p-0">
      <button class="position-absolute top-0 bottom-0 p-0 border-0 bg-none text-secondary" type="button" data-bs-target="#carouselMainPc" data-bs-slide="next">
        <i class="bi bi-chevron-compact-right w-100 fs-1" aria-hidden="true"></i>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <!-- mobile용 -->
  <div class="row d-flex d-lg-none">
    <div class="col-1 position-relative p-0">
      <button class="position-absolute top-0 bottom-0 p-0 border-0 bg-none text-secondary" type="button" data-bs-target="#carouselMainMobile" data-bs-slide="prev">
        <i class="bi bi-chevron-compact-left w-100 fs-1" aria-hidden="true"></i>
        <span class="visually-hidden">Previous</span>
      </button>
    </div>
    <div id="carouselMainMobile" class="carousel slide col-10 p-0">
      <div class="carousel-inner">
        <?php foreach ($themaList as $key => $value) : ?>
          <div class="carousel-item <?= $key === 0 ? "active" : "" ?>">
            <div class="d-flex w-100 w-md-50" style="height:230px;">
              <img
                class="w-auto h-100 pe-3"
                src="/images/posters/<?= empty($value['image']) ? "sample.jpg" : $value['image'] ?>"
                alt="<?= $value['title'] ?> 포스터" />
              <div class="d-flex flex-column pe-5px">
                <h5 class="fs-5 fw-bold text-dark"><?= $value['title'] ?></h5>
                <p class="bg-body-secondary px-2 py-1 rounded-5 fs-xs fw-bold text-secondary d-inline-block mb-2 w-auto me-auto">난이도<?= $starHTMLs[$key] ?></p>
                <p class="three-line keep-all fs-sm">
                  <?= $value['description'] ?>
                </p>
                <a href="/reserve?t=<?= $value['id'] ?>" class="btn fs-xs btn-primary rounded-0 mt-auto me-auto d-inline-block w-auto px-4 py-2 fw-bold">예약하기</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php if (count($chunkThemaList) === 0) : ?>
          <div class="carousel-item active">
            <div class="d-md-flex">
              <div class="d-flex w-100 w-md-50" style="height:230px;">
                <img class="w-auto h-100 pe-3" src="/images/posters/sample.jpg" />
                <div class="d-flex flex-column pe-5px">
                  <h5 class="fs-5 fw-bold text-dark">테마 준비중</h5>
                  <p class="three-line keep-all fs-sm">
                    아직 오픈된 테마가 없습니다.
                  </p>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-1 position-relative p-0">
      <button class="position-absolute top-0 bottom-0 p-0 border-0 bg-none text-secondary" type="button" data-bs-target="#carouselMainMobile" data-bs-slide="next">
        <i class="bi bi-chevron-compact-right w-100 fs-1" aria-hidden="true"></i>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</article>

<article class="bg-secondary-subtle mt-5 mt-md-0">
  <ul class="nav-contour nav container py-3 my-3 fs-sm py-md-5 my-md-5 fs-md-6 fs-lg-5 fw-light d-flex justify-content-between align-items-center text-dark">
    <li class="col-6 col-md-3">
      <div class="contour-line d-flex justify-content-center align-items-center">
        <i class="bi bi-clock-history fs-4 fs-md-2 fs-lg-1 me-3 text-secondary"></i>
        15분전 도착
      </div>
    </li>
    <li class="col-6 col-md-3">
      <div class="contour-line no-md-contour-line d-flex justify-content-center align-items-center">
        <i class="bi bi-volume-mute fs-4 fs-md-2 fs-lg-1 me-3 text-secondary"></i>
        누설 금지
      </div>
    </li>
    <li class="col-6 col-md-3">
      <div class="contour-line d-flex justify-content-center align-items-center">
        <i class="bi bi-telephone-x fs-4 fs-md-2 fs-lg-1 me-3 text-secondary"></i>
        휴대폰 무음
      </div>
    </li>
    <li class="col-6 col-md-3">
      <div class="contour-line d-flex justify-content-center align-items-center">
        <i class="bi bi-bag-x fs-4 fs-md-2 fs-lg-1 me-3 text-secondary"></i>
        파손 주의
      </div>
    </li>
  </ul>
</article>