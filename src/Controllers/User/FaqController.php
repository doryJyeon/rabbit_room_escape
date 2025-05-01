<?php

namespace App\Controllers\User;

use App\Core\BaseController;

class FaqController extends BaseController
{
  public function handle(): void
  {
    // data = [['0:질문', '1:답변']]
    $data = [
      ["질문1", "답변"],
      ["질문2", "답변"]
    ];
    $this->render("faq", [
      "bannerComment" => 'F & A',
      "data" => $data
    ]);
  }
}
