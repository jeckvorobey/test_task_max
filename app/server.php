<?php

require_once '../vendor/autoload.php';

use app\App;

if (isset($_POST) && !empty($_POST)) {
    $imgTmpPath = $_FILES['photo']['tmp_name'];
    $imgName = $_FILES['photo']['name'];
    $imgType = $_FILES['photo']['type'];

    if ($imgType  === 'image/jpeg') {
        $app = new App($imgName, $imgTmpPath);
        $app->imgHash();
    } else {
        echo 'это не файл JPG';
        exit;
    }
}

