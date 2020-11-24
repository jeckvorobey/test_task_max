<?php

use api\Api;

require_once __DIR__ . '/vendor/autoload.php';

$api = new Api();

unset($argv['0']);

  switch ($argv['1']) {
    case 'post':
      $res = $api->localPost($argv['2']);
      echo $res;
      break;

    case 'get':
      echo $argv['2'];
      break;
    default:
      echo "ошибка - это не POST и не GET запрос\n";
}
