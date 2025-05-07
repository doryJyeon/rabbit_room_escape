<?php

namespace App\Helpers;

class ImageHelper
{
  // 포스터 300 * 424 기본 해상도, 원본 저장 안함
  public static function resizeAndSave(string $src, string $dst, int $targetW = 300, int $targetH = 424): void
  {
    $info = getimagesize($src);
    if (!$info) return;

    [$w, $h] = $info;
    $mime = $info['mime'];

    switch ($mime) {
      case 'image/jpeg':
        $srcImg = imagecreatefromjpeg($src);
        break;
      case 'image/png':
        $srcImg = imagecreatefrompng($src);
        break;
      case 'image/gif':
        $srcImg = imagecreatefromgif($src);
        break;
      default:
        return;
    }

    $dstImg = imagecreatetruecolor($targetW, $targetH);
    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $targetW, $targetH, $w, $h);

    switch ($mime) {
      case 'image/jpeg':
        imagejpeg($dstImg, $dst, 90);
        break;
      case 'image/png':
        imagepng($dstImg, $dst);
        break;
      case 'image/gif':
        imagegif($dstImg, $dst);
        break;
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);
  }
}
