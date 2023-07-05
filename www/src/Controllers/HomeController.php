<?php

namespace Src\Controllers;

use Error;
use PDO;
use Src\Helpers\Dev;

class HomeController extends BaseController
{
    public function index()
    {
        $conn = new PDO('mysql:host=172.30.0.5:3306;dbname=php', "root", "root");
        Dev::console($conn);
        return $this->renderView("pages.home");
    }
}
