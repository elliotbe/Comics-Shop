<?php
namespace App\Entities;

class Entity {

  public function __get($name) {
    $method = 'get' . ucwords($name);
    return $this->$method();
  }

}
