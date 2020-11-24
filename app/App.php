<?php

namespace app;

include './config/config.php';

use core\Model;
use core\Error;
use ErrorException;
use Exception;

class App
{
    public function __construct()
    {
    }
    /**
     * Получает Hash фотографии и сравнивает ее на наличие в БД
     * Если такая фотография уже загружалась возвращает результат её обработки
     * Если такой фото нет в БД сохраняет на диске и заносит путь в БД
     */
    public function checkTask($photoName, $photoPath)
    {
        $imgHash = md5_file($photoPath . $photoName);
        $model = new Model;
        $task = $model->checkPhotoHash($imgHash);
        if (!$task) {
            $status = 'received';
            $taskId = $model->setTask($photoName, $imgHash, $status); //Записывает данные задания в БД сто статусом received
            $task = $model->getTask($taskId[0]['LAST_INSERT_ID()']);  //получаем данные только, что вставленного задания
            return json_encode($task);
        } else {
            //отдаем прочитаный результат
        }
    }

    public function getTask($task_id)
    {
        //получаем задачу по её Id возвращаем JSON строку 
    }
}
