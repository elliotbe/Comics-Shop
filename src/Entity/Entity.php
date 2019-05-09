<?php
declare(strict_types = 1);
namespace App\Entity;

class Entity {

  public function __get(string $name) :?string {
    $name = ucfirst(snakeToCamel($name));
    $method = "get$name";
    return $this->$method();
  }

}
