<?php

use Dotenv\Dotenv;
use Src\Helpers\Database;
use Src\Helpers\Dev;
use Src\Helpers\Dir;
use Src\Helpers\Session;
use Src\Models\Queue\QueueModel;

require_once("/var/www/html/src/configs.php");
require_once("/var/www/html/vendor/autoload.php");

Session::start();
$dotenv = Dotenv::createImmutable(Dir::getRootDir());
$dotenv->load();
$GLOBALS[DATABASE_GLOBAL_KEY] = new Database();

function run()
{
    $queue_model = new QueueModel();
    $job = $queue_model->getFirst();
    if ($job && $job->status === QUEUE_STATUS_OPEN) {
        try {
            $queue_model->setInProgress($job->uid);
            $listener = $job->class;
            $listener_instance = new $listener();
            $listener_instance->handle(json_decode($job->data));
            $queue_model->setDone($job->uid);
            Dev::writeLog(json_encode($job), "queue");
            run();
        } catch (\Throwable $th) {
            $queue_model->setDone($job->uid);
            Dev::writeLog(json_encode($th->getMessage()), "error", LOG_STATUS_ERROR);
            Dev::writeLog(json_encode($job), "queue", LOG_STATUS_ERROR);
        }
    }
}

run();
