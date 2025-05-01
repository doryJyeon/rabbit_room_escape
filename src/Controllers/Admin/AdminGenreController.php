<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Genre;
use Exception;

class AdminGenreController extends AdminBaseController
{
  public function handle(): void
  {
    $getList = Genre::getAll();
    $this->render("genre_home", [
      "title" => "Admin-Rabbit room escape",
      "getList" => $getList
    ]);
  }

  public function info($id)
  {
    $themaList = Genre::getThema($id);
    $this->render("genre_thema_list", [
      "title" => "Genre-Thema list",
      "themaList" => $themaList
    ]);
  }

  // 추가
  public function store(): void
  {
    $genre_name = trim($_POST['genre_name']) ?? null;
    if (!$genre_name) {
      $this->setToastMsg("error", "필수 항목이 누락되었습니다.", "/admin/genre");
    }

    // 중복 체크
    $exists = Genre::findName($genre_name);
    if ($exists) {
      $this->setToastMsg("error", "중복된 장르입니다.", "/admin/genre");
    }

    try {
      Genre::create([
        'genre_name' => $genre_name
      ]);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      $this->setToastMsg("error", $err->getMessage(), "/admin/genre");
    }
    $this->setToastMsg("success", "추가했습니다.", "/admin/genre");
  }

  // 삭제
  public function destroy(): void
  {
    if (!isset($_POST['id']) || empty($_POST['id'])) {
      $this->$this->setToastMsg("error", "관련 정보를 찾을 수 없습니다.", "/admin/genre");
    }
    $id = $_POST['id'];

    // 연결된 테마 체크
    $exists = count(Genre::getThema($id));
    if ($exists) {
      $this->setToastMsg("error", "사용 중인 장르입니다.\n테마에서 먼저 변경해주세요.", "/admin/genre");
    }

    try {
      Genre::deleteGenre($id);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      $this->setToastMsg("error", $err->getMessage(), "/admin/genre");
    }
    $this->setToastMsg("success", "삭제했습니다.", "/admin/genre");
  }
}
