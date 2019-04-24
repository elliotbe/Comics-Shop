<?php
namespace App\Entities;

class Entity {

  public function __get(string $name) :callable {
    $method = 'get' . ucwords($name);
    return $this->$method();
  }

}
