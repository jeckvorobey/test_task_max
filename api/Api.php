<?php

namespace api;

class Api
{
    public $ch;
    public $name;
    public $data = [];

    public function __construct()
    {
    }

    public function post($name, $url, $photoPath, $retry_id = null)
    {
        $this->name = $name;
        $dir = __DIR__ . $photoPath . $this->name;
        $cfile = curl_file_create($dir, 'image/jpg');

        if (is_null($retry_id)) {
            $this->data = [
              'name' => $this->name,
              'photo' => $cfile
            ];
        } else {
            $this->data = [
            'retry_id' => $retry_id
          ];
        }

        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data);

        $response = curl_exec($this->ch);

        $curl_errno = curl_errno($this->ch);
        $curl_error = curl_error($this->ch);

        curl_close($this->ch);


        if ($curl_errno > 0) {
            return "cURL Error ($curl_errno): $curl_error\n";
        } else {
            return $response;
        }
    }

    public function get($taskId)
    {
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, URL_LOCAL . '?taskId=' . $taskId);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, 1);

        $response = curl_exec($this->ch);

        $curl_errno = curl_errno($this->ch);
        $curl_error = curl_error($this->ch);

        curl_close($this->ch);


        if ($curl_errno > 0) {
            return "cURL Error ($curl_errno): $curl_error\n";
        } else {
            return $response;
        }
    }
}
