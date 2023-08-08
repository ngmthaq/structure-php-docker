<?php

// For meta tags
define("AUTHOR", "ngmthaq");
define("COUNTRY", "Viet Nam");
define("STREET_ADDRESS", "Phu Do, Nam Tu Liem, Ha Noi");
define("LOCALE", "vi");

// HTTP Response code
define("STT_OK", 200);
define("STT_NO_CONTENT", 204);
define("STT_BAD_REQUEST", 400);
define("STT_UNAUTHORIZED", 401);
define("STT_FORBIDDEN", 403);
define("STT_NOT_FOUND", 404);
define("STT_INTERNAL_SERVER_ERROR", 500);
define("STT_SERVICE_UNAVAILABLE", 503);

// Log status
define("LOG_STATUS_INFO", "INFO");
define("LOG_STATUS_ERROR", "ERROR");

// Key
define("AUTH_KEY", "__AUTH_KEY__");
define("DATABASE_GLOBAL_KEY", "__DATABASE_GLOBAL_KEY__");
define("LOCALE_KEY", "__LOCALE_KEY__");
define("FLASH_MESSAGE_KEY", "__FLASH_MESSAGE_KEY__");
define("REQUEST_GLOBAL_KEY", "__REQUEST_GLOBAL_KEY__");
define("THROTTLE_SESSION_KEY", "__THROTTLE_SESSION_KEY__");
define("XSRF_KEY", "XSRF_TOKEN");

// Throttle
define("THROTTLE_LIMIT_PER_MINUTE", 60);

// Queue
define("QUEUE_STATUS_OPEN", 0);
define("QUEUE_STATUS_IN_PROGRESS", 1);
define("QUEUE_TYPE_NORMAL", "NORMAL");
define("QUEUE_TYPE_STATIC", "STATIC");
