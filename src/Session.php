<?php
declare(strict_types = 1);
namespace App;

class Session {

  public function __construct() {

  }

  public function set(string $key, string $value) :void {
    $_SESSION[$key] = $value;
  }

  public function get(string $key) {
    return $_SESSION[$key];
  }

  public function setFlash(string $type, string $message) :void {
    $_SESSION['flash'][$type] = $message;
  }

  public function getFlash() :array {
    return $_SESSION['flash'];
  }

  public function removeFlash() :void {
    unset($_SESSION['flash']);
  }

}
