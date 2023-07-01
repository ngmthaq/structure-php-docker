<?php

namespace Src\Controllers;

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
     */
    protected function sendJson(array $data, int $status)
    {
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($data);
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
