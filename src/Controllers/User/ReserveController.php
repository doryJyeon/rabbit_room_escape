<?php

namespace App\Controllers\User;

use App\Core\BaseController;
use App\Helpers\StarIcon;
use App\Helpers\DayOfWeek;
use App\Models\Thema;
use App\Models\ThemaPrice;
use App\Models\ThemaSchedule;
use App\Models\Reservation;
use Exception;

class ReserveController extends BaseController
{
  private ?string $step = "1";
  private ?string $date = null;
  private ?string $themaId = null;
  private string $redirect = "/reserve?";

  public function __construct()
  {
    $this->step = $_GET['step'] ?? "1";
    $this->date = $_GET['date'] ?? date('Y-m-d');
    $this->themaId = $_GET['t'] ?? null;
    $this->redirect = "/reserve?date=$this->date";
  }

  public function handle(): void
  {
    // step 1만 여기서, 나머지 2~4는 store
    if ($this->step === "1") {
      $allThema = Thema::getAll();
      $themas = Thema::getSchedule($this->themaId, $this->date);
      $themaSchedule =  [];
      foreach ($themas as $key => $value) {
        // get star icons
        $themas[$key]["starHTMLs"] = StarIcon::getStarIcon($value['level']);

        // explode thema times
        $ids = explode(",", $value['schedule_id']) ?? null;
        $times = explode(",", $value['schedule_time']) ?? null;
        $statuss = explode(",", $value['schedule_status']) ?? null;

        if (count($ids) && count($times) && count($statuss)) {
          foreach ($ids as $idx => $item) {
            $themaSchedule[$value['thema_id']][$item] = [
              "schedule_id" => $item,
              "schedule_time" => $times[$idx],
              "schedule_status" => $statuss[$idx],
            ];
          }
        }
      }
      $this->render("reserve", [
        "bannerComment" => "예약하기",
        "step" => $this->step,
        "date" => $this->date,
        "allThema" => $allThema,
        "themas" => $themas,
        "themaSchedule" => $themaSchedule,
        "selectThema" => $this->themaId,
      ]);
    } else {
      header("Location: $this->redirect");
      exit;
    }
  }

  public function store(): void
  {
    // step 2, 3, 4는 여기서 처리
    $scheduleId = $_POST['s'] ?? null;

    // 테마 스케줄 선택 완료 & 예약자 정보 받기
    if ($this->themaId === null) {
      $this->setToastMsg("error", "선택된 테마가 없습니다.", $this->redirect);
    }
    if ($scheduleId === null) {
      $this->setToastMsg("error", "선택된 스케줄 정보가 없습니다.", $this->redirect);
    }
    $thema = Thema::findId($this->themaId); // 테마
    $schedule = ThemaSchedule::findId($scheduleId); // 스케줄
    if ($schedule['status'] === "close") {
      $this->setToastMsg("error", "예약 마감되었습니다.", $this->redirect);
    }
    $schedule['dayWeek'] = DayOfWeek::getDayKorean($schedule['date']);
    $prices = ThemaPrice::getPrice($this->themaId); // 인원수 별로 order 되서 가져옴
    $themaPrice = [];
    foreach ($prices as $key => $value) {
      $themaPrice[$value['person']] = $value['price'];
    }

    $params = [
      "bannerComment" => "예약하기",
      "step" => $this->step,
      "date" => $this->date
    ];

    if ($this->step === "2") {
      $params['thema'] = $thema;
      $params['schedule'] = $schedule;
      $params['basePrice'] = number_format($prices[0]['price'] ?? 0);
      $params['price'] = json_encode($themaPrice);
    } else if ($this->step === "3") {
      // 예약 정보 완료 & 예약 정보 출력 & 예약금 받기
      $name = $_POST['name'] ?? null;
      $phone = (!empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['phone3'])) ? $_POST['phone1'] . $_POST['phone2'] . $_POST['phone3'] : null;
      $persons = $_POST['persons'] ?? null;

      if (empty($name) || empty($phone) || empty($persons)) {
        $this->setToastMsg("error", "정보를 제대로 입력해주세요.", $this->redirect);
      }
      $params['data'] = [
        "themaId" => $this->themaId,
        "scheduleId" => $scheduleId,
        "title" => $thema['title'],
        "date" => $schedule['date'],
        "dayWeek" => $schedule['dayWeek'],
        "time" => $schedule['schedule_time'],
        "price" => number_format($themaPrice[$persons] ?? 0),
        "persons" => $persons,
        "name" => $name,
        "phone" => $phone
      ];
    } else if ($this->step === "4") {
      // 최종 예약 완료(관리자 승인)
      $data = [
        "thema_schedule_id" => $scheduleId,
        "name" => $_POST['name'] ?? null,
        "phone" => $_POST['phone'] ?? null,
        "persons" => $_POST['persons'] ?? null
      ];
      // 정보 체크
      foreach ($data as $key => $value) {
        if (empty($value)) {
          $this->setToastMsg("error", "필수 정보가 누락 되었습니다.", $this->redirect);
        }
      }
      // insert
      try {
        $reservedId = Reservation::create($data);
        ThemaSchedule::updateStatus(["status" => "close"], $scheduleId);
      } catch (Exception $err) {
        error_log("[ERROR] " . $err->getMessage());
        $this->setToastMsg("error", $err->getMessage(), $this->redirect);
      }
      // insert Id로 예약 정보 찾기
      $reservedData = Reservation::findId($reservedId);
      $reservedData['dayWeek'] = DayOfWeek::getDayKorean($reservedData['date']);

      $params['data'] = $reservedData;
    }
    $this->render("reserve", $params);
  }
}
