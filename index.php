<?php


require_once __DIR__ . '/vendor/autoload.php';

include './config/config.php';

use app\App;

if(isset($_POST) && !empty($_FILES)){
  print_r($_FILES);
  echo "\n";
  echo "***Записываем в БД***\n";
  echo "***Выполняем запрос к API сервера***\n\n";

  if(!file_exists($_FILES['photo']['tmp_name'])) {
    echo "Файл не существует\n";
    die;
  }
  $app = new App;
  $res = $app->checkTask($_FILES['photo']['name'], $_FILES['photo']['tmp_name']);
  return $res;
}

if(isset($_GET) && !empty($_GET['taskId'])) {
  $app = new App;
  $app->getTask($_GET['taskId']);
}