<?php

use api\Api;

require_once __DIR__ . '/vendor/autoload.php';

include './config/config.php';

$api = new Api();

unset($argv['0']);

  switch ($argv['1']) {
    case 'post':
      $name = $argv['2'] . '.jpg';
      $res = $api->post($name, URL_LOCAL, TMP_PHOTO_DIREEKTORY);
      echo "$res\n";
      break;

    case 'get':
      $res = $api->get($argv['2']);
      echo "$res\n";
      break;
    default:
      echo "ошибка - это не POST и не GET запрос\n";
}
