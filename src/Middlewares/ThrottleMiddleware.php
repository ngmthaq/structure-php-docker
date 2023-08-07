<?php

namespace Src\Middlewares;

use Src\Helpers\Dev;
use Src\Helpers\Dir;

class ThrottleMiddleware extends BaseMiddleware
{
    public function handle(): void
    {
        if ($_ENV["APP_ENV"] === "production") {
            $addr = $_SERVER["REMOTE_ADDR"];
            if (empty($_SESSION[THROTTLE_SESSION_KEY])) {
                $_SESSION[THROTTLE_SESSION_KEY] = [];
            }
            if (empty($_SESSION[THROTTLE_SESSION_KEY][$addr])) {
                $_SESSION[THROTTLE_SESSION_KEY][$addr] = ["throttle" => 0, "time" => time()];
                $this->next();
            } else {
                $time = $_SESSION[THROTTLE_SESSION_KEY][$addr]["time"];
                $current_time = time();
                if ($current_time - $time <= 60) {
                    $throttle = $_SESSION[THROTTLE_SESSION_KEY][$addr]["throttle"];
                    if ($throttle <= THROTTLE_LIMIT_PER_MINUTE) {
                        $_SESSION[THROTTLE_SESSION_KEY][$addr]["throttle"] += 1;
                        $this->next();
                    } else {
                        $this->res->sendUnavailableStatus();
                    }
                } else {
                    $_SESSION[THROTTLE_SESSION_KEY][$addr] = ["throttle" => 0, "time" => time()];
                    $this->next();
                }
            }
        } else {
            $this->next();
        }
    }
}
