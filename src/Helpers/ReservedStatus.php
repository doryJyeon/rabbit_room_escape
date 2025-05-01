<?php

namespace App\Helpers;

class ReservedStatus
{
  /**
   * reserved status 한국어로 변환
   */
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
  /**
   * 버튼 색 구분용
   */
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
  /**
   * 예약금 제외한 최종 금액
   */
  public static function leftPrice($status, $totalPrice): string
  {
    // confirmed === 예약금(20,000원) 들어옴 -> 최종 금액 - 2만원으로 return 
    $discount = $status === "confirmed" ? 20000 : 0;
    $totalPrice = (int) str_replace(",", "", $totalPrice);

    return number_format($totalPrice - $discount);
  }
}
