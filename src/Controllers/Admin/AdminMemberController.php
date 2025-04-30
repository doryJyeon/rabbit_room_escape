<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Admin\AdminMember;
use Exception;

class AdminMemberController extends AdminBaseController
{
  public function member(): void
  {
    $list = AdminMember::getAll();
    $this->render("admin_member", [
      "title" => "Admin-members",
      "list" => $list
    ]);
  }

  // 추가
  public function store(): void
  {
    // id / pw check
    $login_id = $_POST['login_id'] ?? null;
    $pw = $_POST['pw'] ?? null;
    if (empty($login_id) || empty($pw)) {
      $this->setToastMsg("error", "아이디/비밀번호 값이 없습니다.", "/admin/member");
    }
    $hashPw = password_hash($pw, PASSWORD_DEFAULT);

    // position check
    $positions = ['staff', 'manager', 'executive', 'sys_admin'];
    if (!in_array($_POST['position'], $positions)) {
      $this->setToastMsg("error", "잘못된 직급입니다.", "/admin/member");
    }

    $data = [
      "login_id" => $login_id,
      "password" => $hashPw,
      "phone" => $_POST['phone'] ?? null,
      "position" => $_POST['position']
    ];

    // 중복 체크
    $exists = AdminMember::findId($login_id);
    if ($exists) {
      $this->setToastMsg("error", "중복된 아이디입니다.", "/admin/member");
    }

    try {
      AdminMember::create($data);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/member");
    }
    $this->setToastMsg("success", "추가했습니다.", "/admin/member");
  }

  // 삭제
  public function destroy(): void
  {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
      $this->$this->setToastMsg("error", "관련 정보를 찾을 수 없습니다.", "/admin/member");
    }
    $id = $_POST['id'];

    try {
      AdminMember::deleteAdmin($id);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/member");
    }
    $this->setToastMsg("success", "삭제했습니다.", "/admin/member");
  }
}
