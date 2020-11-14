<?php

require_once '../vendor/autoload.php';

use app\App;
use core\Model;

if (isset($_POST) && !empty($_POST)) {
    $imgTmpPath = $_FILES['photo']['tmp_name'];
    $imgName = $_FILES['photo']['name'];
    $imgType = $_FILES['photo']['type'];

    if ($imgType  === 'image/jpeg') {
        $app = new App($imgName, $imgTmpPath);
        echo $app->imgHash();
    } else {
        echo 'это не файл JPG';
        exit;
    }
}

if (isset($_GET) && ($_GET['taskId'] > 0)) {
    print_r($_GET);
}
