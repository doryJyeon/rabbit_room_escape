<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;

class AdminHomeController extends AdminBaseController
{
  public function home(): void
  {
    $this->render("home", [
      "title" => "Admin-Rabbit room escape"
    ]);
  }
}
