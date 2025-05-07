<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Thema;
use App\Models\ThemaSchedule;
use Exception;

class AdminScheduleController extends AdminBaseController
{
  public function handle(): void
  {
    $this->render("schedule", [
      "title" => "테마 일정"
    ]);
  }

  /**
   * date는 필수로 있어야함.
   * @param t :themaId
   * @param date 
   */
  public function info($id)
  {
    $themaId = $_GET['t'] ?? null;
    // date 값 없으면 오늘 날짜로 
    $date = $_GET['date'] ?? date('Y-m-d');

    $themas = Thema::getSchedule($themaId, $date);
    $themaSchedule =  [];
    foreach ($themas as $key => $value) {
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
    $this->render("schedule_detail", [
      "title" => "테마별 일정표",
      "themas" => $themas,
      "themaSchedule" => $themaSchedule,
      "selectThema" => $themaId,
      "selectDate" => $date
    ]);
  }

  // 추가
  public function store()
  {
    $date = $_POST['date'];
    $data = [
      "thema_id" => $_POST['thema_id'],
      "date" => $_POST['date']
    ];
    if ($_POST['multiple'] === "false") {
      $data["time"] = $_POST['hour'] . ":" . $_POST['minute'];
    } else {
      // 다중 추가, 숫자:, 제외한 부분 replace 후 배열 변경
      $times = explode(",", preg_replace('/[^0-9:,]/', '', $_POST['times'] ?? ''));
      // 중복 시간 체크
      foreach ($times as $key => $value) {
        if (ThemaSchedule::countThemaTime($data['thema_id'], $data['date'], $value, $_POST['play_time'] ?? 50) !== 0) {
          return $this->setToastMsg("error", "$value 시간대에 스케줄이 있습니다.", "/admin/schedule/1&date=$date");
        }
      }
      $data["time"] = $times;
    }

    try {
      if ($_POST['multiple'] === "false") {
        // 중복 시간 체크
        if (ThemaSchedule::countThemaTime($data['thema_id'], $data['date'], $data['time'], $_POST['play_time'] ?? 50) !== 0) {
          $this->setToastMsg("error", "해당 시간대에 스케줄이 있습니다.", "/admin/schedule/1&date=$date");
        } else {
          ThemaSchedule::create($data);
        }
      } else {
        ThemaSchedule::createMulti($data);
      }
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      $this->setToastMsg("error", $err->getMessage(), "/admin/schedule/1&date=$date");
    }
    $this->setToastMsg("success", "저장했습니다.", "/admin/schedule/1&date=$date");
  }

  // 삭제
  public function destroy(): void
  {
    $date = $_POST['date'] ?? null;
    $id = $_POST['id'] ?? null;
    if (empty($date) || empty($id)) {
      $this->$this->setToastMsg("error", "관련 정보를 찾을 수 없습니다.", "/admin/schedule/1&date=$date");
    }

    // 스케줄 상태 체크
    $scheduleInfo = ThemaSchedule::findId($id);
    if ($scheduleInfo['status'] === "close") {
      $this->setToastMsg("error", "예약된 스케줄입니다.\n예약 취소 후 다시 시도해주세요.", "/admin/schedule/1&date=$date");
    }

    try {
      ThemaSchedule::deleteSchedule($id);
    } catch (Exception $err) {
      error_log("[ERROR] " . $err->getMessage());
      $this->setToastMsg("error", $err->getMessage(), "/admin/schedule/1&date=$date");
    }
    $this->setToastMsg("success", "삭제했습니다.", "/admin/schedule/1&date=$date");
  }
}
