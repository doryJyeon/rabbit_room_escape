<?php

namespace App\Controllers\User;

use App\Core\BaseController;
use App\Helpers\StarIcon;
use App\Models\Thema;

class ThemaController extends BaseController
{
  public function handle(): void
  {
    $themaJoinList = Thema::getAllJoinInfo();
    $starHTMLs = [];
    foreach ($themaJoinList as $key => $value) {
      $starHTMLs[$key] = StarIcon::getStarIcon($value['level']);
    }
    $this->render("thema", [
      "bannerComment" => "테마",
      "themaJoinList" => $themaJoinList,
      "starHTMLs" => $starHTMLs
    ]);
  }
}
