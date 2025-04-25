<?php

namespace App\Models;

use App\Models\BaseModel;

class Thema extends BaseModel
{
  public static function getAll()
  {
    return self::all("thema");
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
