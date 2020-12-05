<?php

namespace core;

use core\Db;
use Exception;

class Model
{
    public function __construct()
    {
        self::dbConnect();
        self::init();
    }

    private static function dbConnect()
    {
        $dbConfig = include __DIR__ . '/../config/dbConfig.php';

        Db::getInstance()->Connect($dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_base'], $dbConfig['db_host'], $dbConfig['db_port']);
    }

    private static function init()
    {
      $tbl = 'CREATE TABLE IF NOT EXISTS `task_tbl` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `status` VARCHAR(150) NOT NULL,
        `result` VARCHAR(150) NULL,
        `photo_name` VARCHAR(150) NOT NULL,
        `photo_hash` VARCHAR(150) NOT NULL,
        `retry_id` VARCHAR(150) NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `photo_hash` (`photo_hash`)
      )ENGINE=InnoDB AUTO_INCREMENT=1';
      try {
          Db::getInstance()->Query($tbl);
      } catch(Exception $e) {
        echo $e;
      }
    }

    public function checkPhotoHash($photoHash)
    {
        $res = Db::getInstance()->Select('SELECT `id`, `status`,`result` FROM `task_tbl` WHERE `photo_hash` = :photoHash', ['photoHash' => $photoHash]);
        return $res['0'];
    }

    public function setTask($status, $result, $photoName, $photoHash)
    {
        Db::getInstance()->Query('INSERT INTO `task_tbl`(`status`, `result`, `photo_name`, `photo_hash`) VALUES (
      :photoName, :photoHash, :stat, :result)', [
        'stat' => $status,
        'result' => $result,
        'photoName' => $photoName,
        'photoHash' => $photoHash
      ]);
        return Db::getInstance()->Select('SELECT LAST_INSERT_ID()');
    }

    public function getTaskId($taskId)
    {
        $res =  Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `id` = :taskId', ['taskId' => $taskId]);
        return $res[0];
    }

    public function getRetryId($retryId)
    {
        $res =  Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `retry_id` = :retryId', ['retryId' => $retryId]);
        return $res[0];
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
