<?php

namespace app;

require_once '../config/config.php';

use core\Model;
use core\Task;
use core\Error;
use Exception;

class App
{
    private $photoName = '';
    private $photoPath = '';

    public function __construct($photoName, $photoPath)
    {
        $this->photoName = $photoName;
        $this->photoPath = $photoPath;
    }

    public function getPhotoName()
    {
        return $this->photoName;
    }

    public function getPhotoPath()
    {
        return $this->photoPath;
    }
    /**
     * Получает Hash фотографии и сравнивает ее на наличие в БД
     * Если такая фотография уже загружалась возвращает результат её обработки
     * Если такой фото нет в БД сохраняет на диске и заносит путь в БД
     */
    public function imgHash()
    {
        $imgHash = md5_file($this->photoPath);
        $model = new Model;
        $task = false;
        $model->checkPhotoHash($imgHash);
        if (!$task) {
            $hashName = md5($this->photoName);
            move_uploaded_file($this->photoPath,__DIR__ . '/' . PHOTO_DIRECTORY . '/' . $hashName . '.jpg');
        }
    }
}