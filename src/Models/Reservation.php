<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Reservation extends BaseModel
{
  public static function findId($id)
  {
    $stmt = self::db()->prepare(
      "SELECT
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
        left join thema_price tp on tp.thema_id = t.id and tp.person = r.persons;
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
}
