<?php

namespace App\Models\Admin;

use App\Models\BaseModel;

class AdminMember extends BaseModel
{
  public static function getAll()
  {
    return self::all("admins");
  }

  public static function findId($id)
  {
    return self::findById("admins", $id);
  }

  public static function findLoginId($id)
  {
    return self::findByColumn("admins", "login_id", $id);
  }

  public static function create(array $data)
  {
    return self::insert("admins", $data);
  }

  public static function updateAdmin(array $data, $id)
  {
    return self::update("admins", $data, $id);
  }

  public static function deleteAdmin($id)
  {
    return self::delete("admins", $id);
  }
}
