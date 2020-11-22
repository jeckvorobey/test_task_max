<?php

use app\App;

require_once __DIR__ . '/vendor/autoload.php';

$app = new App();

unset($argv['0']);

  switch($argv['1']){
    case 'post': 
      $res = $app->checkTask($argv['2']);
      echo $res;
      break;

    case 'get':
      echo $argv['2'] . "\n";
    break;
    default: 
      echo "ошибка - это не пост и не гет запрос \n";
}
