<?php

namespace Src\Controllers;

use Src\Helpers\Cookies;
use Src\Helpers\Database;
use Src\Helpers\Request;
use Src\Helpers\Response;
use stdClass;

class BaseController extends stdClass
{
    public Database $db;
    public Request $req;
    public Response $res;

    public function __construct()
    {
        $this->db = $GLOBALS[DATABASE_GLOBAL_KEY];
        $this->req = new Request();
        $this->res = new Response();

        if ($lang = $this->req->getParams("lang")) {
            Cookies::set(LOCALE_KEY, $lang);
        }
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
