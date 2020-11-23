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

    public function localPost($name)
    {
      $name = $this->name . '.jpg';
      $cfile = curl_file_create(__DIR__ . '../files/photo/' . $name, 'image/jpg');

      $this->data = [
        'name' => $name,
        'photo' => $cfile
      ];

      $this->ch = curl_init();

      curl_setopt($this->ch, CURLOPT_URL, "http://localhost:8000/index.php");
      curl_setopt($this->ch, CURLOPT_HEADER, 1);
      curl_setopt($this->ch, CURLOPT_POST, 1);
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data);
      //curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);

      $response = curl_exec($this->ch);

      $curl_errno = curl_errno($this->ch);
      $curl_error = curl_error($this->ch);

      curl_close($this->ch);

      if($curl_errno > 0) {
        return "cURL Error ($curl_errno): $curl_error\n";
      } else{
        return $response;
      }
    }
}
