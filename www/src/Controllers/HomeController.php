<?php

namespace Src\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->sendJson(["hello" => "World"], 200);
    }

    public function home()
    {
        echo "home";
    }
}
