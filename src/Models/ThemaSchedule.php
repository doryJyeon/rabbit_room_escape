<?php

namespace App\Models;

use App\Models\BaseModel;
use Exception;
use PDO;

class ThemaSchedule extends BaseModel
{
  public static function findId($id)
  {
    $stmt = self::db()->prepare(
      "SELECT *,
        date_format(`time`, '%H:%i') as schedule_time
      FROM thema_schedule 
      WHERE id = ?
      "
    );
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * insert 스케줄 시간대 안걸리는지 체크
   */
  public static function countThemaTime($themaId, $date, $time, $playTime)
  {
    $stmt = self::db()->prepare(
      "SELECT count(1) as count
      from thema_schedule 
      where thema_id = :thema_id
      and `date` = :date
      and `time` <= addtime(time(:time), sec_to_time(:play_time * 60)) 
      and addtime(`time`, sec_to_time(:play_time * 60)) >= time(:time) 
      "
    );
    $stmt->execute([
      ":thema_id" => $themaId,
      ":date" => $date,
      ":time" => $time,
      ":play_time" => $playTime
    ]);
    return (int) ($stmt->fetch(PDO::FETCH_ASSOC))['count'] ?? 0;
  }

  public static function create($data)
  {
    return self::insert("thema_schedule", $data);
  }

  public static function createMulti($data)
  {
    $thema_id = $data['thema_id'];
    $date = $data['date'];
    if (empty($thema_id) || empty($date) || count($data['time']) < 1 || empty($data['time'][0])) throw new Exception("시간 데이터가 없습니다.");

    $newTimes = [];
    foreach ($data['time'] as $time) {
      $time = trim($time);
      if (preg_match('/^([01]?\d|2[0-3]):([0-5]\d)$/', $time)) {
        $newTimes[] = "($thema_id, '$date', '$time')";
      }
    }
    if (empty($newTimes)) {
      throw new Exception("잘못된 시간 형식입니다.");
    }

    $sql = "INSERT into thema_schedule (thema_id, `date`, `time`) values" . implode(",", $newTimes);
    return self::db()->query($sql);
  }

  public static function updateStatus($status, $id)
  {
    return self::update("thema_schedule", ["status" => $status], $id);
  }

  public static function deleteSchedule($id)
  {
    return self::delete("thema_schedule", $id);
  }
}
