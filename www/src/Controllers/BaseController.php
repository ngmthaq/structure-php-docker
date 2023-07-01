<?php

namespace Src\Controllers;

use eftec\bladeone\BladeOne;
use Src\Helpers\Dir;

abstract class BaseController
{
    /**
     * Processed $_GET array
     */
    protected array $params;

    /**
     * Processed $_POST array
     */
    protected array $inputs;

    /**
     * Processed $_FILES array
     */
    protected array $files;

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
    protected function sendJson(array $data, int $status = 200)
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
    protected function renderView(string $view, array $data = [], int $status = 200)
    {
        http_response_code($status);
        $cached_view_dir = Dir::getDirFromSrc("/Cached/Views");
        if (!file_exists($cached_view_dir)) mkdir($cached_view_dir);
        $view_dir = Dir::getDirFromSrc("/Views");
        $blade = new BladeOne($view_dir, $cached_view_dir, BladeOne::MODE_DEBUG);
        $blade->pipeEnable=true;
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
