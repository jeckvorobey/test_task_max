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
    public $retryId = null;
    public $taskId = 0;
    public $status = 'received';
    public $result = null;
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
                $this->taskJson($task);
        } else {
            if (!move_uploaded_file($photoTmpPath, __DIR__ . PHOTO_DIRECTORY . $this->photoName)) {
                echo "Ошибка сохранения файла\n";
                die;
            }
            
            $taskId = $this->model->setTask($this->photoName, $this->hashPhoto, $this->status, $this->result); //Записывает данные задания в БД сто статусом received
            $this->taskId = $taskId[0]['LAST_INSERT_ID()'];

            
            
            $data = $this->api->post($this->photoName, URL_API, PHOTO_DIRECTORY); //отправляем фото на сервер
            $this->taskJson($this->model->getTaskId($this->taskId)); //получаем данные только, что вставленного задания
            $data = json_decode($data, true); //парчим полученый
            $this->model->updateStatus($data['status'], $data['result'], $data['retry_id'], $this->taskId); //обновляем данные в бд
            $item = $this->model->getTaskId($this->taskId);

            if ($data['status'] === 'wait') {
                $this->upResult($item['retry_id']);
            } 
    
        }
    }

    public function upResult($retryId)
    {
        $task = $this->model->getRetryId($this->retryId);
        $data = $this->api->postApi(URL_API, $retryId);

        $data = json_decode($data, true);

        if ($data['status'] === 'wait') {
            $this->model->updateStatus($data['status'], $data['result'], $data['retry_id'], $task['id']);

            sleep(2);

            $this->upResult($data['retry_id']);
        }
        
        if ($data['status'] === 'success') {
            $this->model->updateStatus($data['status'], $data['result'], $data['retry_id'], $task['id']);
            exit;
        }
        
        echo "Ошибка обновления данных\n";
        
        exit;
    }

    public function getTask($taskId)
    {
        $task = $this->model->getTaskId($taskId);

        if (!$task) {
            $res = [
            'status' => 'not_found',
            'result' => null
            ];

            echo json_encode($res) . "\n";
        } else {
            $this->taskJson($task);
        }
    }

    public function taskJson($task)
    {
        $this->taskId = $task['id'];
        $this->status = $task['status'];
        $this->result = $task['result'];


        $res = [
            'status' => $this->status,
            'task' => $this->taskId,
            'result' => $this->result
        ];

        echo json_encode($res) . "\n";
    }
}
