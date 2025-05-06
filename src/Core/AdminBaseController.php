<?php

namespace App\Core;

use App\Helpers\ToastMsg;
use App\Models\Admin\Auth;

class AdminBaseController extends ToastMsg
{
  public function __construct()
  {
    if (!Auth::authCheck()) {
      header("Location: /admin/login");
      exit;
    }
  }
  private function getUrl(): string
  {
    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[2] ?? "index";
  }
  protected function render(string $view, array $data = []): void
  {
    $activeUrl = $this->getUrl();
    // create 필요한 페이지 url 모음. ex) admin/thema->thema 해당 부분 일치 시 생성
    $creates = [
      "thema"
    ];
    // key = 메뉴명, menu = admin/menu: url 주소
    $navs = [
      "장르 관리" => [
        "menu" => "genre",
        "icon" => "bi-bookmark-star"
      ],
      "테마 관리" => [
        "menu" => "thema",
        "icon" => "bi-book"
      ],
      "테마 스케줄 관리" => [
        "menu" => "schedule",
        "icon" => "bi-calendar"
      ],
      "예약 관리" => [
        "menu" => "reserved",
        "icon" => "bi-list-ul"
      ],
    ];
    // admin user 정보
    $adminInfo = [
      "adminId" => $_SESSION['admin']['id'] ?? null,
      "adminName" => $_SESSION['admin']['login_id'] ?? "Admin",
      "adminPosition" => $_SESSION['admin']['position'] ?? "staff",
    ];

    extract(array_merge(
      $data,
      $navs,
      ["activeUrl" => empty($activeUrl) ? "index" : $activeUrl],
      $creates,
      $adminInfo
    ));
    include __DIR__ . '/../Views/layout/header.php';
    include __DIR__ . '/../Views/layout/admin_nav.php';
    include __DIR__ . '/../Views/admin/' . $view . '.php';
    include __DIR__ . '/../Views/layout/admin_footer.php';
  }
}
