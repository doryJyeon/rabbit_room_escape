<?php

namespace App\Controllers\Admin;

class AdminLoginController
{
  public function handle(): void
  {
    extract([
      "title" => "login"
    ]);
    include __DIR__ . '/../../Views/layout/header.php';
    include __DIR__ . '/../../Views/admin/login.php';
  }
}
