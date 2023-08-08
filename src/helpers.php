<?php

use Src\Helpers\Lang;
use Src\Models\Queue\QueueEntity;
use Src\Models\Queue\QueueModel;

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

function setupQueue(QueueEntity $entity)
{
    $queue_model = new QueueModel();
    $queue_model->create($entity);
    shell_exec("php /var/www/html/queue.php > /dev/null 2>&1 &");
}
