<?php

namespace App\Helpers;

class ReservedStatus
{
  public static function statusKo($status): string
  {
    $statusKo = [
      "pending" => "신청",
      "confirmed" => "확정",
      "canceled" => "취소",
      "denied" => "거부",
    ];

    return $statusKo[$status];
  }
  public static function statusColor($status): string
  {
    $statusColor = [
      "pending" => "warning",
      "confirmed" => "success",
      "canceled" => "secondary",
      "denied" => "danger",
    ];

    return $statusColor[$status];
  }
}
