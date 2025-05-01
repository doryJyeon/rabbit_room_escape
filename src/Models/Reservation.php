<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Reservation extends BaseModel
{
  /** Read */
  public static function getAll($date = null, $themaId = null)
  {
    $sql = "SELECT
        r.id as reservedId,
        r.name as user_name,
        regexp_replace(r.phone, '([0-9]{3})([0-9]{4})([0-9]{4})', '$1-$2-$3') as phone,
        r.persons,
        r.status,
        ts.`date`,
        date_format(ts.`time`, '%H:%i') as time,
        t.title,
        format(tp.price, 0) as price
        from reservation r 
        left join thema_schedule ts on ts.id = r.thema_schedule_id 
        left join thema t on t.id = ts.thema_id
        left join thema_price tp on tp.thema_id = t.id and tp.person = r.persons
        where 1 = 1
      ";
    $params = [];
    if ($date) {
      $sql .= " and ts.`date` = :date ";
      $params[":date"] = $date;
    }
    if ($themaId) {
      $sql .= " and t.id = :themaId ";
      $params[":themaId"] = $themaId;
    }
    $sql .= " order by ts.`date`, ts.`time` ";
    $stmt = self::db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function findId($id)
  {
    $stmt = self::db()->prepare(
      "SELECT
        r.id as reservedId,
        ts.id as scheduleId,
        r.name as user_name,
        regexp_replace(r.phone, '([0-9]{3})([0-9]{4})([0-9]{4})', '$1-$2-$3') as phone,
        r.persons,
        r.status,
        ts.`date`,
        date_format(ts.`time`, '%H:%i') as time,
        t.title,
        format(tp.price, 0) as price,
        date_format(r.updated_at, '%Y-%m-%d %H:%i') as updated_at
        from reservation r 
        left join thema_schedule ts on ts.id = r.thema_schedule_id 
        left join thema t on t.id = ts.thema_id
        left join thema_price tp on tp.thema_id = t.id and tp.person = r.persons
        where r.id = :reservationId
      "
    );
    $stmt->execute([":reservationId" => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  /** Insert */
  public static function create(array $data)
  {
    self::insert("reservation", $data);
    return self::db()->lastInsertId();
  }

  public static function updateStatus($status, $id)
  {
    return self::update("reservation", ["status" => $status], $id);
  }
}
