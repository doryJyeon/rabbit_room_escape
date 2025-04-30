<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Admin\AdminMember;
use Exception;

class AdminMyPageController extends AdminBaseController
{
  public function handle(): void
  {
    $checkPw = false;
    // getPw == 유저 패스워드 검증
    $getPw = $_POST['password'] ?? null;
    if ($getPw) {
      $adminId = $_SESSION['admin']['id'];
      $adminInfo = AdminMember::findId($adminId);
      if (!password_verify($getPw, $adminInfo['password'])) {
        $this->setToastMsg("error", "비밀번호가 틀렸습니다.", "/admin/my_page");
      } else {
        $checkPw = true;
      }
    }
    $this->render("my_page", [
      "title" => "My page",
      "checkPw" => $checkPw
    ]);
  }

  // 비밀번호 변경
  public function update(): void
  {
    // getPw == 유저 패스워드 검증
    $getPw = $_POST['password'] ?? null;
    $getNewPw = $_POST['newPw'] ?? null;
    $getNewPw2 = $_POST['newPw2'] ?? null;

    if ($getPw === null || $getNewPw2 === null) {
      $this->setToastMsg("error", "입력된 비밀번호가 없습니다.", "/admin/my_page");
    }
    if ($getNewPw !== $getNewPw2) {
      $this->setToastMsg("error", "새로운 비밀번호가 맞지 않습니다.", "/admin/my_page");
    }
    // 현재 비밀번호 검증
    $adminId = $_SESSION['admin']['id'];
    $adminInfo = AdminMember::findId($adminId);
    if (!password_verify($getPw, $adminInfo['password'])) {
      $this->setToastMsg("error", "비밀번호가 틀렸습니다.", "/admin/my_page");
    }

    $hashPw = password_hash($getNewPw, PASSWORD_DEFAULT);
    try {
      AdminMember::updateAdmin(["password" => $hashPw], $adminId);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/my_page");
    }
    $this->setToastMsg("success", "추가했습니다.", "/admin/");
  }
}
