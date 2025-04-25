<?php

namespace App\Controllers\User;

use App\Core\BaseController;
use App\Models\Thema;

class IndexController extends BaseController
{
  public function handle(): void
  {
    $themaList = Thema::getAll();
    $this->render("index", [
      "themaList" => $themaList ?? null
    ]);
  }
}
