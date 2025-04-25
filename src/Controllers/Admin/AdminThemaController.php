<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Thema;
use App\Models\Genre;
use App\Models\ThemaGenres;
use Exception;

class AdminThemaController extends AdminBaseController
{
  public function thema(): void
  {
    $getList = Thema::getAll();
    $this->render("thema_list", [
      "title" => "Admin-Rabbit room escape",
      "themaList" => $getList
    ]);
  }

  public function info($id)
  {
    $thema = Thema::findId($id);
    $genreList = Genre::getAll();
    $connectGenres = ThemaGenres::getGenre($id);
    $this->render("thema_detail", [
      "title" => "Admin-Thema detail",
      "themaInfo" => $thema,
      "genreList" => $genreList,
      "connectGenres" => $connectGenres
    ]);
  }

  public function create()
  {
    $genreList = Genre::getAll();
    $this->render("thema_detail", [
      "title" => "Admin-Thema detail",
      "genreList" => $genreList
    ]);
  }

  public function store()
  {
    $data = [
      "title" => $_POST['title'],
      "level" => $_POST['level'],
      "persons_min" => $_POST['persons_min'],
      "persons_max" => $_POST['persons_max'],
      "play_time" => $_POST['play_time'],
      "description" => $_POST['description']
    ];

    try {
      $themaId = Thema::create($data);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/thema/create");
    }

    // genre save
    if (!empty($_POST['genreIds'])) {
      $this->genreUpdate($themaId);
    }
    $this->setToastMsg("success", "저장했습니다.", "/admin/thema/$themaId");
  }

  public function update()
  {
    $themaId = $_POST['id'] ?? $this->setToastMsg("warning", "Id 정보를 찾을 수 없습니다.", "/admin/thema");
    $data = [
      "title" => $_POST['title'],
      "level" => $_POST['level'],
      "persons_min" => $_POST['persons_min'],
      "persons_max" => $_POST['persons_max'],
      "play_time" => $_POST['play_time'],
      "description" => $_POST['description']
    ];
    foreach ($data as $key => $value) {
      if (trim($value) === "") {
        $this->setToastMsg("warning", "필수 항목이 비어 있습니다.", "/admin/thema/$themaId");
        return;
      }
    }

    try {
      Thema::update("thema", $data, $themaId);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      throw $this->setToastMsg("error", $err->getMessage(), "/admin/thema");
    }

    // genre save
    if (!empty($_POST['genreIds'])) {
      $this->genreUpdate($themaId);
    }
    $this->setToastMsg("success", "수정했습니다.", "/admin/thema/$themaId");
  }

  // thema-genre_code id 매칭
  private function genreUpdate($themaId)
  {
    $genreIds = array_filter(explode(",", $_POST['genreIds']));

    try {
      // 기존 장르 삭제
      ThemaGenres::deleteThemaId($themaId);

      // 장르 추가
      foreach ($genreIds as $value) {
        ThemaGenres::create([
          "thema_id" => $themaId,
          "genre_id" => $value
        ]);
      }
    } catch (Exception $err) {
      throw $this->setToastMsg("error", "장르 추가 실패\n" . $err, "/admin/thema");
    }
  }
}
