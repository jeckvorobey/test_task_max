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

        Db::getInstance()->Connect($dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_base'], $dbConfig['db_host'], $dbConfig['db_port'])
    }

    public function checkPhotoHash($photoHash) 
    {
      return Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `photo_hash` = :photoHash', ['photoHash' => $photoHash]);
    }

    public function setTask($photoName, $photoHash, $status, $result = null) {
      Db::getInstance()->Query('INSERT INTO `task_tbl`(`photo_name`, `photo_hash`, `status`) VALUES (
      `photo_name` = :photoName, `photo_hash` = :photoHash, `status` = :stat)', [
        'photoName' => $photoName, 
        'photoHash' => $photoHash, 
        'stat' => $status
      ]);
      return Db::getInstance()->Select('SELECT LAST_INSERT_ID()');
    }

    public function getTask($taskId){
      $res =  Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `id` = :taskId', ['taskId' => $taskId]);
      return $res[0];
    }
}
