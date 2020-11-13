<?php

namespace app;

use core\Error;
use Exception;

class App {

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

}