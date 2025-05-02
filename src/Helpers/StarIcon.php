<?php

namespace App\Helpers;

class StarIcon
{
  /**
   * level-난이도를 star icon으로 반환
   * @param level 
   * return html string
   */
  public static function getStarIcon(string $level = "0.5"): string
  {
    $html = '';
    $levelInt = (int) $level; // 정수 추출(만족)
    // $nullInt = (int) (5 - $level); // 정수 추출(불만족/비어있는거)

    // 만족
    for ($i = 0; $i < $levelInt; $i++) {
      $html .= '<i class="bi bi-star-fill text-warning ms-1"></i>';
    }
    // 정수보다 크면 0.5 하프 저장
    if ($levelInt < $level) {
      $html .= '<i class="bi bi-star-half text-warning ms-1"></i>';
    }
    // null 값 표시 x. 만족된 별만 출력
    // null
    // for ($i = 0; $i < ($nullInt); $i++) {
    //   $html .= '<i class="bi bi-star text-warning ms-1"></i>';
    // }
    return $html;
  }
}
