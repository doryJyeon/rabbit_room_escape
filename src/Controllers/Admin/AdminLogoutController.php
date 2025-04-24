<?php

namespace App\Controllers\Admin;

session_start();

class AdminLogoutController
{
  public function logout(): void
  {
    session_unset();
    session_destroy();

    // 쿠키 제거
    setcookie("remember_token", "", time() - 3600, "/");

    header("Location: /admin/login");
    exit;
  }
}
