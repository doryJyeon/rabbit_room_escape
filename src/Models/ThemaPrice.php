<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class ThemaPrice extends BaseModel
{
  // thema_id로 인당 가격 찾기
  public static function getPrice($id)
  {
    $stmt = self::db()->prepare("SELECT * from thema_price where thema_id = ? order by person");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // 생성 전 지우기 필수(update/delete 없음)
  public static function create(array $data)
  {
    return self::insert("thema_price", $data);
  }

  // 일치하는 thema id 삭제
  public static function deleteThemaId($id)
  {
    $stmt = self::db()->prepare("DELETE from thema_price where thema_id = ?");
    return $stmt->execute([$id]);
  }
}
