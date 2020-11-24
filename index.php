<?php

use app\App;

if(isset($_POST) && !empty($_FILES)){
  print_r($_FILES);
  echo "\n";
  echo "***Записываем в БД***\n";
  echo "***Выполняем запрос к API сервера***\n\n";

  $app = new App;
  $app->checkTask($_FILES['name'], $_FILES['tmp_name']);

}