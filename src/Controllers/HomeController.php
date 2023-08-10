<?php

namespace Src\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $this->res->renderView("pages.home");
    }
}
