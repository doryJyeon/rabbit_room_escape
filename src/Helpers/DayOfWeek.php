<?php

namespace App\Helpers;

class DayOfWeek
{
  public static function getDayKorean($date): string
  {
    $weeks = [
      "일",
      "월",
      "화",
      "수",
      "목",
      "금",
      "토",
    ];
    $dayIdx = date('w', strtotime($date));

    return $weeks[$dayIdx];
  }
}
