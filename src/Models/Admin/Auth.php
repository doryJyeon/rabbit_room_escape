<?php

namespace App\Models\Admin;

use App\Models\BaseModel;
use Exception;
use PDO;

class Auth extends BaseModel
{
  public static function login(array $data): void
  {
    $userInfo = self::findByColumn("admins", "login_id", $data['login_id']);
    $user = $userInfo[0] ?? null;
    if (!$user || !password_verify($data['password'], $user['password'])) {
      throw new Exception("아이디 또는 비밀번호가 올바르지 않습니다.");
    }

    // 로그인 성공
    // 로그인 시각 업데이트
    $stmt = self::db()->prepare("UPDATE admins SET update_at = NOW() WHERE id = :id");
    $stmt->execute([':id' => $user['id']]);

    // 세션 저장
    $_SESSION['admin'] = [
      'id' => $user['id'],
      'login_id' => $user['login_id'],
      'position' => $user['position']
    ];

    // 자동 로그인 처리
    if ($data['remember']) {
      $token = bin2hex(random_bytes(32));
      $hashedToken = hash('sha256', $token);

      // DB에 토큰 저장 (유효기간 30일)
      $stmt = self::db()->prepare(
        "UPDATE admins SET
        remember_token = :token,
        token_expires_at = DATE_ADD(NOW(), INTERVAL 30 DAY) 
        WHERE id = :id
      "
      );
      $stmt->execute([
        ':token' => $hashedToken,
        ':id' => $user['id']
      ]);

      // 쿠키 설정
      setcookie("remember_token", $token, time() + (86400 * 30), "/", "", true, true);
    }
  }

  public static function authCheck(): bool
  {
    // 세션 인증
    if (!empty($_SESSION['admin'])) {
      return true;
    }

    // 자동 로그인 쿠키 처리
    if (!empty($_COOKIE['remember_token'])) {
      $token = $_COOKIE['remember_token'];
      $hashedToken = hash('sha256', $token);

      $stmt = self::db()->prepare(
        "SELECT id, login_id FROM admins 
        WHERE remember_token = :token AND token_expires_at > NOW()
        "
      );
      $stmt->execute([":token" => $hashedToken]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        // 자동 로그인 성공
        $_SESSION['admin'] = [
          'id' => $user['id'],
          'login_id' => $user['login_id'],
          'position' => $user['position']
        ];

        // 로그인 시각 업데이트
        $stmt = self::db()->prepare("UPDATE admins SET update_at = NOW() WHERE id = :id");
        $stmt->execute([':id' => $user['id']]);
        return true;
      }
    }

    return false;
  }
}
