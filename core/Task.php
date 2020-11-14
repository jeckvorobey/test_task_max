<?php

namespace core;

use core\Model

class Task
{
    private $id = null;
    private $photoPath = '';
    private $photoHash = '';
    private $status = '';

    public function __construct($photoPath ,$photoHash, $status)
    {
      
    }

    public function getId() {
      return $this->id;
    }

    public function setId($id) {
      $this->id = $id;
    }

    public function getPhotoPath() {
      return $this->photoPath;
    }

    public function setPhotoPath($photoPath) {
      $this->id = $photoPath;
    }

    public function getPhotoHash() {
      return $this->photoHash;
    }

    public function setPhotoHash($photoHash) {
      $this->photoHash = $photoHash;
    }

    public function getStatus() {
      return $this->status;
    }

    public function setStatus($status) {
      $this->status = $status;
    }

    public function checkPhoto(
      {
        
      }
    )
}
