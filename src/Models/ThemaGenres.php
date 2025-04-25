<?php

namespace App\Models;

use App\Models\BaseModel;
use PDO;

class ThemaGenres extends BaseModel
{
  // genre_id로 thema 찾기
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

  // thema_id로 genre 찾기
  public static function getGenre($id)
  {
    return self::findByColumn("thema_genres", "thema_id", $id);
  }

  public static function create(array $data)
  {
    return self::insert("thema_genres", $data);
  }

  // 일치하는 thema id 삭제
  public static function deleteThemaId($id)
  {
    $stmt = self::db()->prepare("DELETE FROM thema_genres WHERE thema_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
