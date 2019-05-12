<?php
declare(strict_types = 1);
namespace App;

class Cookie {

  static public function set(string $cookie_name, string $cookie_value, int $duration) {
    $timestamp = time() + $duration;
    setcookie($cookie_name, $cookie_value, $timestamp, '/');
  }

  static public function get(string $cookie_name) {
    return $_COOKIE[$cookie_name] ?? null;
  }

  static public function delete(string $cookie_name) {
    setcookie($cookie_name, '', -1, '/');
  }

}
