<?php

namespace Src\Models\Base;

use Src\Helpers\Database;
use stdClass;

abstract class BaseDao extends stdClass
{
    protected Database $db;

    public function __construct()
    {
        $this->db = $GLOBALS[DATABASE_GLOBAL_KEY];
    }
}
