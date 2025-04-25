<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class Thema extends BaseModel
{
  public static function getAll()
  {
    return self::all("thema");
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

  public static function findId($id)
  {
    return self::findById("thema", $id);
  }

  public static function create(array $data)
  {
    self::insert("thema", $data);
    return self::db()->lastInsertId();
  }

  public static function updateThema($id, $data)
  {
    return self::update("thema", $data, $id);
  }
}
