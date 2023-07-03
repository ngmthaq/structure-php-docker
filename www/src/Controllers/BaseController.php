<?php

namespace Src\Controllers;

use eftec\bladeone\BladeOne;
use Src\Helpers\Common;
use Src\Helpers\Cookies;
use Src\Helpers\Dev;
use Src\Helpers\Dir;
use Src\Helpers\Hash;
use Src\Helpers\Header;
use Src\Helpers\Number;
use Src\Helpers\Session;
use Src\Helpers\Str;

class BaseController
{
    /**
     * Processed $_GET array
     */
    public array $params;

    /**
     * Processed $_POST array
     */
    public array $inputs;

    /**
     * Processed $_FILES array
     */
    public array $files;

    public function __construct()
    {
        $this->params = $this->prepareArray($_GET);
        $this->inputs = $this->prepareArray($_POST);
        $this->files = $_FILES;
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
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($data);
        exit();
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
        http_response_code($status);
        header("Content-Type: text/html; charset=utf-8");
        $cached_view_dir = Dir::getDirFromSrc("/Cached/Views");
        if (!file_exists($cached_view_dir)) mkdir($cached_view_dir);
        $view_dir = Dir::getDirFromSrc("/Views");
        $blade = new BladeOne($view_dir, $cached_view_dir, BladeOne::MODE_DEBUG);
        $blade->pipeEnable = true;
        $blade->addAliasClasses("Common", Common::class);
        $blade->addAliasClasses("Cookies", Cookies::class);
        $blade->addAliasClasses("Dev", Dev::class);
        $blade->addAliasClasses("Dir", Dir::class);
        $blade->addAliasClasses("Hash", Hash::class);
        $blade->addAliasClasses("Header", Header::class);
        $blade->addAliasClasses("Number", Number::class);
        $blade->addAliasClasses("Session", Session::class);
        $blade->addAliasClasses("Str", Str::class);
        echo $blade->run($view, $data);
        exit();
    }

    /**
     * Prepare array
     * 
     * @param array $array
     * @return array
     */
    private function prepareArray(array $array)
    {
        $output = [];
        foreach ($array as $key => $value) {
            if (gettype($value) === "array") {
                $output[$key] = $this->prepareArray($value);
            } elseif (gettype($value) === "string") {
                $output[$key] = htmlspecialchars(trim($value));
            } else {
                $output[$key] = $value;
            }
        }
        return $output;
    }
}
