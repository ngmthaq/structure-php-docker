<?php

namespace Src\Helpers;

use eftec\bladeone\BladeOne;

class Response
{
    private Request $req;

    public function __construct()
    {
        $this->req = new Request();
    }

    /**
     * Send json response
     * 
     * @param array $data
     * @param int $status
     * @return void
     */
    public function sendJson(array $data, int $status = STT_OK)
    {
        echo json_encode($data);
        $output = ob_get_clean();
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        echo $output;
    }

    public function sendPreLight()
    {
        http_response_code(STT_NO_CONTENT);
        header("Content-Type: application/json; charset=utf-8");
    }

    public function sendUnavailableStatus()
    {
        http_response_code(STT_SERVICE_UNAVAILABLE);
        header("Content-Type: application/json; charset=utf-8");
    }

    /**
     * Render view using template engine (BladeOne)
     * 
     * @param string $view
     * @param array $data
     * @param int $status
     * @return void
     */
    public function renderView(string $view, array $data = [], int $status = STT_OK)
    {
        $cached_view_dir = Dir::getDirFromSrc("/Cached/Views");
        if (!file_exists($cached_view_dir)) mkdir($cached_view_dir);
        $view_dir = Dir::getDirFromSrc("/Views");
        $blade = new BladeOne($view_dir, $cached_view_dir, BladeOne::MODE_DEBUG);
        $blade->pipeEnable = true;
        $blade->addAliasClasses("Auth", Auth::class);
        $blade->addAliasClasses("Common", Common::class);
        $blade->addAliasClasses("Cookies", Cookies::class);
        $blade->addAliasClasses("Dev", Dev::class);
        $blade->addAliasClasses("Dir", Dir::class);
        $blade->addAliasClasses("Hash", Hash::class);
        $blade->addAliasClasses("Header", Header::class);
        $blade->addAliasClasses("Lang", Lang::class);
        $blade->addAliasClasses("Number", Number::class);
        $blade->addAliasClasses("Session", Session::class);
        $blade->addAliasClasses("Str", Str::class);
        $flash_messages = [];
        if (isset($_SESSION[FLASH_MESSAGE_KEY])) {
            $flash_messages = $_SESSION[FLASH_MESSAGE_KEY];
            unset($_SESSION[FLASH_MESSAGE_KEY]);
        }
        $additional_data = ["params" => $this->req->getParams(), "flash_messages" => $flash_messages];
        $data = array_merge($data, $additional_data);
        echo $blade->run($view, $data);
        $output = ob_get_clean();
        http_response_code($status);
        header("Content-Type: text/html; charset=utf-8");
        echo $output;
    }

    /**
     * Redirect
     * 
     * @param string $path
     * @param array $params
     * @return void
     */
    public function redirect(string $path, array $params = [])
    {
        $query_parameters = http_build_query($params);
        $query_parameters = $query_parameters === "" ? "" : "?" . $query_parameters;
        header("Location: " . $path .  $query_parameters);
    }

    /**
     * Reload
     * 
     * @return void
     */
    public function reload()
    {
        header("Refresh:0");
    }
}
