<?php

namespace App\Helpers;

class ToastMsg
{
  // error || success 저장
  public static function setToastMsg(string $type, string $msg, string $location): void
  {
    if ($type === "error") {
      $_SESSION["error"] = $msg;
      header("Location: $location");
      exit;
    } else if ($type === "success") {
      $_SESSION["success"] = $msg;
      header("Location: $location");
      exit;
    }
  }

  // html 반환
  public static function getToastMsg(): string
  {
    $html = '<div class="toast-container top-0 end-0 mt-2 me-2" id="headerToast">';
    if (isset($_SESSION['error']) && !empty(trim($_SESSION['error']))) {
      $html .= '
      <div class="toast" role="alert" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header">
          <i class="bi bi-x-circle text-danger me-2"></i>
          <strong class="me-auto">Error!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">' . nl2br(htmlspecialchars($_SESSION['error'])) . '</div>
      </div>';
    }
    if (isset($_SESSION['success']) && !empty(trim($_SESSION['success']))) {
      $html .= '
      <div class="toast" role="alert" aria-atomic="true" data-bs-delay="1300">
        <div class="toast-header">
          <i class="bi bi-check-circle text-success me-2"></i>
          <strong class="me-auto">Success</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">' . nl2br(htmlspecialchars($_SESSION['success'])) . '</div>
      </div>';
    }
    $html .= '</div>';

    unset($_SESSION['error']);
    unset($_SESSION['success']);

    return $html;
  }
}
