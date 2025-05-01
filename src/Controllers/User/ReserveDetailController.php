<?php

namespace App\Controllers\User;

use App\Core\BaseController;
use App\Helpers\DayOfWeek;
use App\Helpers\ReservedStatus;
use App\Models\Reservation;

class ReserveDetailController extends BaseController
{
  private ?string $name = null;
  private ?string $phone = null;
  private ?string $reservedId = null;
  private string $redirect = "/reserve_detail";

  public function __construct()
  {
    $this->name = $_POST['name'] ?? null;
    $this->phone = (!empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['phone3'])) ? $_POST['phone1'] . $_POST['phone2'] . $_POST['phone3'] : null;
    $this->reservedId = $_POST['rId'] ?? null;
  }

  public function handle(): void
  {
    $params = [
      "bannerComment" => "예약확인 및 취소",
      "name" => $this->name
    ];
    // 받은 예약자명(name) 있으면 list, 없으면 form
    if ($this->name) {
      // 예약 내역 확인
      if ($this->name === null) {
        $this->setToastMsg("error", "예약자명이 없습니다.", $this->redirect);
      }
      if ($this->phone === null) {
        $this->setToastMsg("error", "연락처가 없습니다.", $this->redirect);
      }
      if ($this->reservedId === null) {
        $this->setToastMsg("error", "예약 번호가 없습니다.", $this->redirect);
      }

      // insert Id로 예약 정보 찾기
      $reservedData = Reservation::findId($this->reservedId);
      // 데이터 비교
      if ($reservedData['user_name'] !== $this->name || str_replace("-", "", $reservedData['phone']) !== $this->phone) {
        $this->setToastMsg("error", "입력한 정보와 일치하는 예약이 없습니다.", $this->redirect);
      }
      $reservedData['dayWeek'] = DayOfWeek::getDayKorean($reservedData['date']);
      $reservedData['statusKo'] = ReservedStatus::statusKo($reservedData['status']);
      $reservedData['leftPrice'] = ReservedStatus::leftPrice($reservedData['status'], $reservedData['price']);
      // 예약 확정 === 예약금(20,000) 입금된걸로 봄.
      $reservedData['isConfirmed'] = $reservedData['status'] === "confirmed";
      $params["data"] = $reservedData;
    } else {
      // 예약자 정보 입력
    }
    $this->render("reserve_detail", $params);
  }
}
