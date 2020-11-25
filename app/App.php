<?php

namespace app;

include './config/config.php';

use core\Model;
use api\Api;
use core\Error;
use ErrorException;
use Exception;

class App
{
    public $hashPhoto = '';
    public $photoName ='';
    public $status = 'received';
    public $result = null;
    public $taskId = 0;
    public $model;
    public $api;

    public function __construct()
    {
        $this->model = new Model;
        $this->api = new Api;
    }
    /**
     * Получает Hash фотографии и сравнивает ее на наличие в БД
     * Если такая фотография уже загружалась возвращает результат её обработки
     * Если такой фото нет в БД сохраняет на диске и заносит путь в БД
     */
    public function checkTask($photoName, $photoTmpPath)
    {
        $this->photoName = $photoName;
        $this->hashPhoto = md5_file($photoTmpPath);
        $task = $this->model->checkPhotoHash($this->hashPhoto);

        

        if ($task) {
            $this->task($task);
        } else {
            if (!move_uploaded_file($photoTmpPath, __DIR__ . PHOTO_DIRECTORY . $this->photoName)) {
                echo "Ошибка сохранения файла\n";
                die;
            }
            
            $taskId = $this->model->setTask($this->photoName, $this->hashPhoto, $this->status, $this->result); //Записывает данные задания в БД сто статусом received
            $task = $this->model->getTaskId($taskId[0]['LAST_INSERT_ID()']);  //получаем данные только, что вставленного задания
    
            $data = $this->api->post($this->photoName, URL_API, PHOTO_DIRECTORY, $this->result);
            $data = json_decode($data);
            $this->model->updateStatus($data['status'], $data['result'], $data['retry_id'], $this->taskId);

            $this->task($task);
        }

    }

    public function checkStatus()
    {
        $res = $this->model->getTaskId($this->taskId);
        $this->status = $res['status'];

        if($this->sattus !== 'sucsses'){

        }
    }

    public function task ($task)
    {
        $this->taskId = $task['id'];
        $this->status = $task['status'];
        $this->result = $task['result'];

        $res = [
            'status' => $this->status,
            'task' => $this->taskId,
            'result' => $this->result
        ];

        echo json_encode($res);
    }

    public function getTask($taskId)
    {
        $this->task($this->model->getTaskId($taskId));
    }
}
