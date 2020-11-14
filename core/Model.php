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
      //, $dbConfig['db_host'], $dbConfig['db_port']

      Db::getInstance()->Connect($dbConfig['db_user'], $dbConfig['db_password'],$dbConfig['db_base']);
    }

    public function checkPhotoHash($photoHash) 
    {
      return Db::getInstance()->Select('SELECT * FROM `task_tbl` WHERE `photo_hash` = :photoHash', ['photoHash' => $photoHash]);
    }
}
