<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dbConfig = include __DIR__ . '/../config/dbConfig.php';
include __DIR__ . '/../config/config.php';

use core\Db;
use api\Api;
use core\Error;

$status = 'wait';


try {
    Db::getInstance()->Connect($dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_base'], '127.0.0.1', $dbConfig['db_port']); //$dbConfig['db_host']
} catch (Exception $e) {
    new Error();
}


try {
    $task =  Db::getInstance()->Select('SELECT `id`, `retry_id` FROM `task_tbl` WHERE `status` = :stat', ['stat' => $status]);
} catch (Exception $e) {
    new Error();
}

if (!$task) {
    exit;
}

$taskId = $task['0']['id'];

$api = new Api;
$data = $api->postApi(URL_API, $task['0']['retry_id']);
$data = json_decode($data, true);
try {
    Db::getInstance()->Query('UPDATE `task_tbl` SET `status`= :stat,`result`= :res,`retry_id`= :retry_id WHERE `id` = :taskId', [
        'stat' => $data['status'],
        'res' => $data['result'],
        'retry_id' => $data['retry_id'],
        'taskId' => $taskId
      ]);
} catch (Exception $e) {
    new Error();
}

exit;
