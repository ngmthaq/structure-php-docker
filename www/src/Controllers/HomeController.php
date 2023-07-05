<?php

namespace Src\Controllers;

use Error;
use PDO;
use Src\Helpers\Dev;

class HomeController extends BaseController
{
    public function index()
    {
        $conn = new PDO('mysql:host=mysql-service;dbname=php;port=3306', "root", "root");
        $this->renderView("pages.home");
        Dev::console($conn);
    }
}
