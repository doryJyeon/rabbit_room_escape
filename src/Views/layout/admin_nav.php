<div class="w-full vh-100 overflow-hidden d-flex bg-secondary">
  <!-- header->nav -->
  <header class="w-100 d-flex flex-column p-3 text-bg-dark vh-100" style="max-width: 220px;">
    <img src="/images/logo.png" alt="logo" width="60" class="mx-auto mt-2" />
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
      <?php if (1) : ?>
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
        <strong>Admin</strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
        <li><a class="dropdown-item" href="/admin/logout">비밀번호 변경</a></li>
        <li><a class="dropdown-item" href="/admin/logout">Sign out</a></li>
      </ul>
    </div>
  </header>

  <!-- 컨텐츠 시작 -->
  <section class="w-100 m-3 rounded bg-white text-dark p-3 pt-5 overflow-y-auto">
    <h1 class="text-capitalize fw-bold text-primary">
      <?= $activeUrl ?>
      <?php if (in_array($activeUrl, $creates)) { ?>
        <a class="btn btn-sm btn-primary" href="/admin/<?= $activeUrl ?>/create">추가하기</a>
      <?php } ?>
    </h1>

    <hr class="border-3 mt-0 border-primary bg-primary opacity-50" />

    <!-- server toast message -->
    <?php echo \App\Helpers\ToastMsg::getToastMsg(); ?>