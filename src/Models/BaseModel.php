<?php

namespace App\Models;

use Exception;
use PDO;

abstract class BaseModel
{
  protected static function db()
  {
    static $db = null;
    if ($db === null) {
      $host = getenv("DB_HOST");
      $dbname = getenv("DB_NAME");
      $user = getenv("DB_USER");
      $pass = getenv("DB_PASS");

      $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $db;
  }

  // 전체 데이터
  public static function all(string $table, $orderDesc = false)
  {
    if ($orderDesc) {
      // 최신순
      $stmt = self::db()->query("SELECT * FROM $table ORDER BY create_at DESC");
    } else {
      $stmt = self::db()->query("SELECT * FROM $table");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // 전체 데이터 & order, limit, offset
  public static function list(string $table)
  {
    $stmt = self::db()->query("SELECT * FROM $table");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // id로 데이터 찾기
  public static function findById(string $table, $id)
  {
    $stmt = self::db()->prepare("SELECT * FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // 특정 컬럼으로 데이터 찾기
  public static function findByColumn(string $table, string $column, $id)
  {
    // 허용한 컬럼 목록
    $allowedColumns = ["login_id", "genre_name", "thema_id"];
    if (!in_array($column, $allowedColumns)) {
      throw new Exception("Invalid column name");
    }

    $stmt = self::db()->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // 데이터 삽입
  public static function insert(string $table, array $data)
  {
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $stmt = self::db()->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    return $stmt->execute(array_values($data));
  }

  // 데이터 업데이트
  public static function update(string $table, array $data, $id)
  {
    $setClauses = [];
    foreach ($data as $columns => $value) {
      $setClauses[] = "$columns = ?";
    }
    $setClauses = implode(", ", $setClauses);
    $stmt = self::db()->prepare("UPDATE $table SET $setClauses WHERE id = ?");
    return $stmt->execute(array_merge(array_values($data), [$id]));
  }

  // 데이터 삭제
  public static function delete(string $table, $id)
  {
    $stmt = self::db()->prepare("DELETE FROM $table WHERE id = ?");
    return $stmt->execute([$id]);
  }
}
