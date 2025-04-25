<?php

namespace App\Core;

abstract class BaseController
{
  private function getUrl(): string
  {
    return explode("/", $_SERVER['REQUEST_URI'])[1] ?? "index";
  }
  protected function render(string $view = "index", array $data = []): void
  {
    $activeUrl = ["activeUrl" => $this->getUrl()];
    extract(array_merge(
      $data,
      $activeUrl
    ));
    include __DIR__ . '/../Views/layout/header.php';
    include __DIR__ . '/../Views/layout/nav.php';
    include __DIR__ . '/../Views/user/' . $view . '.php';
    include __DIR__ . '/../Views/layout/footer.php';
  }

  abstract public function handle(): void;
}
