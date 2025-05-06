<?php

namespace App\Core;

use App\Helpers\ToastMsg;

abstract class BaseController extends ToastMsg
{
  private function getUrl(): string
  {
    return explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[1] ?? "index";
  }
  protected function render(string $view = "index", array $data = []): void
  {
    $activeUrl = $this->getUrl();
    if ($activeUrl !== "privacy") {
      extract(array_merge(
        $data,
        ["activeUrl" => empty($activeUrl) ? "index" : $activeUrl]
      ));
      include __DIR__ . '/../Views/layout/header.php';
      include __DIR__ . '/../Views/layout/nav.php';
      include __DIR__ . '/../Views/user/' . $view . '.php';
      include __DIR__ . '/../Views/layout/footer.php';
    } else {
      include __DIR__ . '/../Views/layout/header.php';
      include __DIR__ . '/../Views/user/' . $view . '.php';
    }
  }

  abstract public function handle(): void;
}
