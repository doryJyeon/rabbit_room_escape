<?php

namespace App\Controllers\Admin;

use App\Core\AdminBaseController;

class AdminIndexController extends AdminBaseController
{
  public function handle(): void
  {
    $this->render("home", [
      "title" => "Admin-Rabbit room escape"
    ]);
  }
}
