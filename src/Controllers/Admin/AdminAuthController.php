<?php

namespace App\Controllers\Admin;

use App\Helpers\ToastMsg;
use App\Models\Admin\Auth;
use Exception;

class AdminAuthController extends ToastMsg
{
  public function store(): void
  {
    if (empty($_POST['login_id']) || empty($_POST['password'])) {
      $this->setToastMsg("error", "로그인 정보가 없습니다.", "/admin/login");
    }
    $data = [
      "login_id" => $_POST['login_id'],
      "password" => $_POST['password'],
      "remember" => $_POST['remember'] ?? false
    ];

    try {
      Auth::login($data);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/login");
    }
    header("Location: /admin/home");
    exit;
  }
}
