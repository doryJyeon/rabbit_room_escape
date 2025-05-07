<div class="w-full vh-100 overflow-hidden d-flex flex-column flex-lg-row bg-secondary">
  <!-- header->nav -->
  <header class="admin-header text-bg-dark position-relative">
    <div class="header-mobile d-flex d-lg-none w-100 px-3 align-items-center justify-content-between">
      <a href="/admin/" class="">
        <img src="/images/logo.png" alt="logo" height="40" class="mx-auto" />
      </a>

      <button class="nav-link text-white fs-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list"></i>
      </button>
    </div>
    <div class="header-pc flex-column text-bg-dark p-3 vh-100" id="sidebarMenu" tabindex="-1" aria-modal="true" role="dialog">
      <a href="/admin/" class="d-block text-center">
        <img src="/images/logo.png" alt="logo" width="60" class="mx-auto mt-2" />
      </a>
      <hr>

      <ul class="nav nav-pills flex-column mb-auto">
        <?php foreach ($navs as $nav => $value) : ?>
          <li class="nav-item">
            <a href="/admin/<?= $value['menu'] ?>" class="nav-link text-white <?= ($value['menu'] === $activeUrl) ? "active" : "" ?>">
              <i class="bi <?= $value['icon'] ?> me-1"></i>
              <?= $nav ?>
            </a>
          </li>
        <?php endforeach; ?>

        <!-- only sys admin -->
        <?php if ($adminPosition === "sys_admin") : ?>
          <li class="nav-item">
            <a href="/admin/member" class="nav-link text-white <?= ($activeUrl === "member") ? "active" : "" ?>">
              <i class="bi bi-person-fill-gear me-1"></i>
              mamber
            </a>
          </li>
        <?php endif; ?>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>
          <strong><?= $adminName ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
          <li><a class="dropdown-item" href="/admin/my_page">비밀번호 변경</a></li>
          <li><a class="dropdown-item" href="/admin/logout">Sign out</a></li>
        </ul>
      </div>
    </div>
  </header>

  <script>
    // header mobile show/hide
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.querySelector('[data-bs-target="#sidebarMenu"]');
      const sidebar = document.getElementById('sidebarMenu');

      toggleBtn.addEventListener('click', function() {
        sidebar.classList.remove('header-pc-none');
      });
    });
  </script>

  <!-- 컨텐츠 시작 -->
  <section class="w-100 vh-100 m-lg-3 rounded bg-white text-dark p-2 p-lg-3 pt-3 pt-lg-5 overflow-y-auto">
    <h1 class="text-capitalize fw-bold text-primary">
      <?= str_replace("_", " ", $activeUrl) ?>
      <?php if (in_array($activeUrl, $creates)) { ?>
        <a class="btn btn-sm btn-primary" href="/admin/<?= $activeUrl ?>/create">추가하기</a>
      <?php } ?>
    </h1>

    <hr class="border-3 mt-0 border-primary bg-primary opacity-50" />