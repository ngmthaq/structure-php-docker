<?php

use Src\Helpers\Lang;

function __(string $key)
{
    return Lang::t($key);
}

function csrf()
{
    $key = XSRF_KEY;
    $token = $_SESSION[XSRF_KEY];
    echo "<input type='hidden' name='$key' value='$token' />";
}
