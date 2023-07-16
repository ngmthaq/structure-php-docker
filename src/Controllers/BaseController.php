<?php

namespace Src\Controllers;

use eftec\bladeone\BladeOne;
use Src\Helpers\Auth;
use Src\Helpers\Common;
use Src\Helpers\Cookies;
use Src\Helpers\Database;
use Src\Helpers\Dev;
use Src\Helpers\Dir;
use Src\Helpers\Hash;
use Src\Helpers\Header;
use Src\Helpers\Number;
use Src\Helpers\Session;
use Src\Helpers\Str;
use Src\Helpers\Lang;

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
     * Database instance
     */
    public Database $db;

    /**
     * Processed $_FILES array
     */
    public array $files;

    public function __construct()
    {
        $this->db = new Database();
        $this->params = $this->prepareArray($_GET);
        $this->inputs = $this->prepareArray($_POST);
        $this->files = $_FILES;
        $GLOBALS[DATABASE_GLOBAL_KEY] = $this->db;
        if (isset($this->params["lang"])) {
            Cookies::set(LOCALE_KEY, $this->params["lang"]);
        }
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
        $additional_data = ["params" => $this->params, "flash_messages" => $flash_messages];
        $data = array_merge($data, $additional_data);
        echo $blade->run($view, $data);
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

    /**
     * Run middlewares
     * 
     * @param array $middlewares
     * @return void
     */
    public function runMiddlewares(array $middlewares)
    {
        if (count($middlewares) > 0) {
            $middleware = array_shift($middlewares);
            $middleware_instance = new $middleware();
            call_user_func(array($middleware_instance, "handle"));
            $this->runMiddlewares($middlewares);
        }
    }

    /**
     * Get full url
     * 
     * @return string
     */
    public function getFullUrl()
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * Prepare array
     * 
     * @param array $array
     * @return array
     */
    public function prepareArray(array $array)
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
