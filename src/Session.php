<?php
declare(strict_types = 1);
namespace App;

class Session {

  public function __construct() {
    session_start([
      'name' => 'comics-shop_ssid',
      'save_path' => ROOT . 'extra/session_storage/'
      ]);
    Cookie::set(session_name(), session_id(), 1200);
  }

  public function set(string $key, $value) {
    $_SESSION[$key] = $value;
  }

  public function get(string $key) {
    return $_SESSION[$key] ?? null;
  }

  public function setFlash(string $type, $message) :void {
    $_SESSION['flash'][$type] = $message;
  }

  public function getFlash() :array {
    return $_SESSION['flash'] ?? [];
  }

  public function removeFlash() :void {
    $_SESSION['flash'] = [];
  }

}
