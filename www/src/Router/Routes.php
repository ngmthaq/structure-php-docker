<?php

namespace Src\Router;

use Src\Controllers\HomeController;

final class Routes extends Configs
{
    /**
     * Register routes with GET method
     * 
     * @return void
     */
    public function registerGetRoutes()
    {
        $this->get(["path" => "/", "controller" => HomeController::class, "action" => "index"]);
        $this->get(["path" => "/home", "controller" => HomeController::class, "action" => "home"]);
    }

    /**
     * RRegister routes with POST method
     * 
     * @return void
     */
    public function registerPostRoutes()
    {
        //
    }

    public function register()
    {
        $this->registerGetRoutes();
        $this->registerPostRoutes();
    }
}
