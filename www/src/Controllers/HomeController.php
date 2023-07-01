<?php

namespace Src\Controllers;

use Error;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->sendJson(["hello" => "World"]);
    }

    public function home()
    {
        return $this->renderView("home");
    }
}
