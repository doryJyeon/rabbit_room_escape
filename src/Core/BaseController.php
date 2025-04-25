<?php

namespace App\Core;

abstract class BaseController
{
  protected function render(string $view = "index", array $data = []): void
  {
    extract($data);
    include __DIR__ . '/../Views/layout/header.php';
    include __DIR__ . '/../Views/layout/nav.php';
    include __DIR__ . '/../Views/user/' . $view . '.php';
    include __DIR__ . '/../Views/layout/footer.php';
  }

  abstract public function handle(): void;
}
