<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use PDO;

class Genre extends BaseModel
{
  public static function getAll()
  {
    return self::all("genre_code", true);
  }

  public static function findId($id)
  {
    return self::findById("genre_code", $id);
  }

  public static function findName($name)
  {
    return self::findByColumn("genre_code", "genre_name", $name);
  }

  public static function getThema($id)
  {
    $stmt = self::db()->prepare(
      "SELECT t.*, gc.genre_name FROM thema_genres tg 
      LEFT JOIN thema t ON tg.thema_id = t.id
      LEFT JOIN genre_code gc ON gc.id = tg.genre_id
      WHERE tg.genre_id = :genre_id
    "
    );
    $stmt->execute(["genre_id" => $id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function create($genre_name)
  {
    return self::insert("genre_code", $genre_name);
  }

  public static function deleteGenre($id)
  {
    return self::delete("genre_code", $id);
  }
}
