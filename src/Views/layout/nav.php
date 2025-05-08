<div>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3">
      <!-- pc -->
      <a href="/" class="d-none d-md-flex align-items-center mb-3 mb-md-0 me-auto link-body-emphasis text-decoration-none">
        <img src="/images/logo.png" class="header-logo me-2" alt="logo" />
        <span class="fs-4 text-logo-color lh-1 align-bottom fw-light">Rabbit <br />room escape</span>
      </a>
      <!-- mobile -->
      <a href="/" class="d-md-none me-auto">
        <img src="/images/logo.png" class="header-logo me-2" alt="logo" />
      </a>

      <ul class="nav nav-pills d-flex flex-wrap align-content-center fs-7">
        <!-- <li class="nav-item"><a href="/rabbit_room" class="nav-link text-dark">About</a></li> -->
        <li class="nav-item"><a href="/thema" class="nav-link text-dark">테마</a></li>
        <li class="nav-item"><a href="/reserve" class="nav-link text-dark">예약</a></li>
        <li class="nav-item"><a href="/faq" class="nav-link text-dark">FAQ</a></li>
      </ul>
    </header>
  </div>

  <main>
    <section class="w-100">
      <?php if (isset($bannerComment)) : ?>
        <article class="main-banner <?= $activeUrl === "index" ? "banner-bic" : "" ?>">
          <div class="benner-gradient"></div>
          <?php if ($activeUrl === "index") : ?>
            <p class="ff-pan text-warning fs-2 benner-font d-md-none h-100 d-flex align-content-center justify-content-center py-4">
              <span class="mt-3">한편의 이야기에 <br>깡총 뛰어들어보세요.</span>
              <img class="reverse-img img-bright ms-3" src="/images/logo.png" alt="logo" style="height: 80px;" />
            </p>
            <p class="ff-pan text-warning fs-lg benner-font d-none d-md-block">
              <?= $bannerComment; ?>
            </p>
          <?php else : ?>
            <p class="ff-pan text-warning fs-lg benner-font">
              <?= $bannerComment; ?>
            </p>
          <?php endif; ?>
        </article>
      <?php endif; ?>