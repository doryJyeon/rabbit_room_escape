<?php

namespace App\Controllers\User;

use App\Core\BaseController;

class PrivacyController extends BaseController
{
  public function handle(): void
  {
    $this->render("privacy", []);
  }
}
