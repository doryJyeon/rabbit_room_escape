<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Thema extends BaseModel
{
  /** Read */
  public static function getAll()
  {
    return self::all("thema");
  }

  public static function findId($id)
  {
    return self::findById("thema", $id);
  }

  // thema + genre join data
  public static function getAllJoinInfo()
  {
    $stmt = self::db()->query(
      "SELECT t.*,
      group_concat(gc.genre_name order by tg.genre_id) as genre_name, 
      group_concat(tg.genre_id order by tg.genre_id) as genre_id 
      from thema t 
      left join thema_genres tg on tg.thema_id = t.id
      left join genre_code gc on gc.id = tg.genre_id
      group by t.id order by t.id
    "
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // thema + schedule join data
  public static function getSchedule($themaId, $date)
  {
    // date 필수! 없으면 오늘 날짜로 받아야함
    $query =
      "SELECT 
        t.id as thema_id,
        t.title,
        t.play_time,
        t.image,
        t.level,
        t.persons_min,
        t.persons_max,
        group_concat(ts.id order by ts.time) as schedule_id,
        group_concat(date_format(ts.time, '%H:%i') order by ts.time) as schedule_time,
        group_concat(status order by ts.time) as schedule_status
      from thema t
      left join thema_schedule ts on t.id = ts.thema_id and ts.date = :date
    ";
    $params = [":date" => $date];
    // 특정 테마 검색
    if (!empty($themaId)) {
      $query .= "WHERE t.id = :thema_id";
      $params[":thema_id"] = $themaId;
    }

    $query .= "group by t.id";

    $stmt = self::db()->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /** Insert */
  public static function create(array $data)
  {
    self::insert("thema", $data);
    return self::db()->lastInsertId();
  }

  /** Update */
  public static function updateThema($id, $data)
  {
    return self::update("thema", $data, $id);
  }
}
