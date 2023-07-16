<?php

namespace Src\Models\Base;

use Src\Helpers\Database;

abstract class BaseDao
{
    protected Database $db;

    public function __construct()
    {
        $this->db = $GLOBALS[DATABASE_GLOBAL_KEY];
    }
}
