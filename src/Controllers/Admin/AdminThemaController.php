<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Thema;
use App\Models\ThemaPrice;
use App\Models\Genre;
use App\Models\ThemaGenres;
use Exception;

class AdminThemaController extends AdminBaseController
{
  public function handle(): void
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
    $themaPrice = ThemaPrice::getPrice($id);
    $genreList = Genre::getAll();
    $connectGenres = ThemaGenres::getGenre($id);
    $this->render("thema_detail", [
      "title" => "Admin-Thema detail",
      "themaInfo" => $thema,
      "themaPrice" => $themaPrice,
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

    // price save
    if (!empty($data['persons_min'])) {
      $this->priceUpdate($themaId, $data['persons_min'], $data['persons_max']);
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

    // price save
    if (!empty($data['persons_min'])) {
      $this->priceUpdate($themaId, $data['persons_min'], $data['persons_max']);
    }
    // genre save
    if (!empty($_POST['genreIds'])) {
      $this->genreUpdate($themaId);
    }
    $this->setToastMsg("success", "수정했습니다.", "/admin/thema/$themaId");
  }

  // thema price create/update
  private function priceUpdate($themaId, $min, $max)
  {
    try {
      // 기존 금액 삭제
      ThemaPrice::deleteThemaId($themaId);

      for ($i = $min; $i <= $max; $i++) {
        ThemaPrice::create([
          "thema_id" => $themaId,
          "person" => $i,
          "price" => str_replace(",", "", $_POST["price$i"])
        ]);
      }
    } catch (Exception $err) {
      throw $this->setToastMsg("error", "금액 추가 실패\n" . $err, "/admin/thema/$themaId");
    }
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
      throw $this->setToastMsg("error", "장르 추가 실패\n" . $err, "/admin/thema/$themaId");
    }
  }
}
