<?php

namespace Src\Helpers;

use Src\Models\User\UserEntity;

class Request
{
    protected array $params;
    protected array $inputs;
    protected array $files;
    protected UserEntity|null $user;

    public function __construct()
    {
        $this->params   =   $this->prepareArray($_GET);
        $this->inputs   =   $this->prepareArray($_POST);
        $this->files    =   $_FILES;
        $this->user     =   Auth::user();
    }

    public function getParams(string $key = "*")
    {
        if ($key === "*") {
            return $this->params;
        } elseif (isset($this->params[$key])) {
            return $this->params[$key];
        } else {
            return null;
        }
    }

    public function getInputs(string $key = "*")
    {
        if ($key === "*") {
            return $this->inputs;
        } elseif (isset($this->inputs[$key])) {
            return $this->inputs[$key];
        } else {
            return null;
        }
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getUser()
    {
        return $this->user;
    }

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
