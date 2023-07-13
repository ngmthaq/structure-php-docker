<?php

namespace Src\Controllers;

use Src\Helpers\Dev;
use Src\Models\User\UserModel;

class HomeController extends BaseController
{
    public function index()
    {
        $user_model = new UserModel();
        $user = $user_model->findOneByUid("993bcf91-e209-4e1c-8b72-54ffde2b3a1d");
        $this->renderView("pages.home", compact("user"));
        Dev::console($user);
    }
}
