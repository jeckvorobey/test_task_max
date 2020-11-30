<?php

namespace core;

use core\Db;

class Model
{
    public function __construct()
    {
      self::dbConnect();
    }

    private static function dbConnect()
    {
        $dbConfig = include __DIR__ . '/../config/dbConfig.php';

        Db::getInstance()->Connect($dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_base'], $dbConfig['db_host'], $dbConfig['db_port']);
    }

    public function checkPhotoHash($photoHash) 
    {
      $res = Db::getInstance()->Select('SELECT `id`, `status`,`result` FROM `task_tbl` WHERE `photo_hash` = :photoHash', ['photoHash' => $photoHash]);
      return $res['0'];
    }

    public function setTask( $status, $result, $photoName, $photoHash) {
      Db::getInstance()->Query('INSERT INTO `task_tbl`(`status`, `result`, `photo_name`, `photo_hash`) VALUES (
      :photoName, :photoHash, :stat, :result)', [
        'stat' => $status,
        'result' => $result,
        'photoName' => $photoName, 
        'photoHash' => $photoHash
      ]);
      return Db::getInstance()->Select('SELECT LAST_INSERT_ID()');
    }

    public function getTaskId($taskId){
      $res =  Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `id` = :taskId', ['taskId' => $taskId]);
      return $res[0];
    }

    public function getRetryId($retryId){
      $res =  Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `retry_id` = :retryId', ['retryId' => $retryId]);
      return $res[0];
    }

    public function getStatus($status){
      $res =  Db::getInstance()->Select('SELECT `retry_id` FROM `task_tbl` WHERE `status` = :stat', ['stat' => $status]);
      return $res;
    }

    public function updateStatus($status, $result, $retry_id, $taskId)
    {
      return Db::getInstance()->Query('UPDATE `task_tbl` SET `status`= :stat,`result`= :res,`retry_id`= :retry_id WHERE `id` = :taskId', [
        'stat' => $status,
        'res' => $result,
        'retry_id' => $retry_id,
        'taskId' => $taskId
      ]);
    }
}
