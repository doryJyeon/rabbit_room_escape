<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Models\Reservation;
use App\Helpers\ReservedStatus;
use App\Models\Thema;

class AdminReservedController extends AdminBaseController
{
  private ?string $date = null;
  private ?string $themaId = null;

  public function __construct()
  {
    $this->date = $_GET['date'] ?? null;
    $this->themaId = $_GET['t'] ?? null;
  }
  public function handle(): void
  {
    // 예약된 list
    $getList = Reservation::getAll($this->date, $this->themaId);
    foreach ($getList as $key => $value) {
      $getList[$key]['statusKo'] = ReservedStatus::statusKo($value['status']);
      $getList[$key]['btnColor'] = ReservedStatus::statusColor($value['status']) ?? "light";
    }
    // 전체 테마
    $themas = Thema::getAll();

    $this->render("reserved", [
      "title" => "예약 관리",
      "date" => $this->date,
      "themaId" => $this->themaId,
      "allThema" => $themas,
      "date" => $this->date,
      "list" => $getList
    ]);
  }
}
