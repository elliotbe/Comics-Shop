<?php
declare(strict_types = 1);
namespace App\Entity;

class Entity {

  // Used to prevent a error when dumping the entity
  public function __toString() {
    return '';
  }

  public function __get(string $name) :string {
    $name = ucfirst(snakeToCamel($name));
    $method = "get$name";
    return $this->$method();
  }

}
