<?php

namespace Src\Models\Base;

use Src\Helpers\Database;

class BaseDao
{
    protected Database $db;

    public function __construct()
    {
        $this->db = $GLOBALS[Database::GLOBAL_KEY];
    }
}
