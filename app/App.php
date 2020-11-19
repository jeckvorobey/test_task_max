<?php

namespace app;

use core\Model;
use core\Error;
use ErrorException;
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
        $task = $model->checkPhotoHash($imgHash);

        if (!$task) {
            $hashPhotoName = md5($this->photoName) . '.jpg';
      
            if (move_uploaded_file($this->photoPath, $_ENV['PHOTO_DIRECTORY'] . '/' . $hashPhotoName)) {
                $status = 'received';
                $taskId = $model->setTask($hashPhotoName, $imgHash, $status); //Записывает данные задания в БД сто статусом received
                $task = $model->getTask($taskId[0]['LAST_INSERT_ID()']);  //получаем данные только, что вставленного задания
                echo json_encode($task);
            }
        }
    }
}
