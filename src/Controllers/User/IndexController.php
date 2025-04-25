<?php

namespace App\Controllers\User;

use App\Core\BaseController;
use App\Models\Thema;
use App\Helpers\StarIcon;

class IndexController extends BaseController
{
  public function handle(): void
  {
    $themaList = Thema::getAll();
    $starHTMLs = [];
    foreach ($themaList as $key => $value) {
      $starHTMLs[$key] = StarIcon::getStarIcon($value['level']);
    }
    $this->render("index", [
      "bannerComment" => '한편의 이야기에<img src="/images/logo.png" class="reverse-img mx-2 img-bright mb-4" width="90px" alt="logo" />깡총 뛰어들어보세요.',
      "themaList" => $themaList ?? null,
      "starHTMLs" => $starHTMLs
    ]);
  }
}
