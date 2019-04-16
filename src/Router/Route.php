<?php
namespace App\Router;

class Route {

  private $path;
  private $callback;
  private $matches = [];
  private $params = [];

  public function __construct(string $path, $callback) {
    $this->path = trim($path, '/');
    $this->callback = $callback;
  }

  public function match(string $url) :bool {
    $url = trim($url, '/');
    $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
    $regex = "#^$path$#i";

    if (\preg_match($regex, $url, $matches) == false) {
      return false;
    };

    \array_shift($matches);
    $this->matches = $matches;

    return true;
  }

  public function call() {
    if (is_object($this->callback)) {
      return \call_user_func_array($this->callback, $this->matches);
    }
  }



}
