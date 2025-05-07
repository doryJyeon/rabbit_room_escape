<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;
use App\Helpers\ImageHelper;

class AdminUploadController extends AdminBaseController
{
  private string $publicDir = __DIR__ . '/../../../public';
  private string $uploadDir = '/uploads/originals/';
  private string $postersDir  = '/images/posters/';

  private function json(bool $success, string $message, array $extra = []): void
  {
    echo json_encode(array_merge([
      'success' => $success,
      'message' => $message,
    ], $extra));
    exit;
  }

  // 현재 이미지 업로드만 허용
  public function store()
  {
    header('Content-Type: application/json');

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      $this->json(false, "이미지 업로드 실패");
    }
    $uploadDir = $_POST['dirName'] === "posters" ? $this->postersDir :  $this->uploadDir;
    $tmp   = $_FILES['image']['tmp_name'];
    $name  = $_FILES['image']['name'];
    $ext   = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    $allow = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allow)) $this->json(false, "지원하지 않는 확장자입니다.");
    if (!getimagesize($tmp))     $this->json(false, "유효한 이미지가 아닙니다.");

    ImageHelper::resizeAndSave($tmp, $this->publicDir . $uploadDir . $name);

    $url = $uploadDir . $name;
    $this->json(true, "업로드 완료", ['src_url' => $url]);
  }
}
