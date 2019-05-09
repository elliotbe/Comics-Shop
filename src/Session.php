<?php
declare(strict_types = 1);
namespace App;

class Session {

  public function __construct() {
    session_start([
      'name' => 'comics-shop_ssid',
      'save_path' => ROOT . 'extra/session_storage/'
      ]);
    setcookie(session_name(), session_id(), time() + 1200, '/');

    $this->get('flash') !== null ?: $this->set('flash', []);
    $this->get('basket') !== null ?: $this->set('basket', []);
  }

  public function set(string $key, $value) {
    $_SESSION[$key] = $value;
  }

  public function get(string $key) {
    return $_SESSION[$key] ?? null;
  }

  public function setFlash(string $type, string $message) :void {
    $_SESSION['flash'][$type] = $message;
  }

  public function getFlash() :array {
    return $this->get('flash');
  }

  public function removeFlash() :void {
    $this->set('flash', []);
  }

}
