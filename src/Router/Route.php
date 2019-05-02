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
    $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
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

    if (is_string($this->callback)) {
      $array = explode('#', $this->callback);
      $controller_name = "\\App\\Controller\\{$array[0]}Controller";
      $controller = new $controller_name();
      $method = $array[1];
      return \call_user_func_array([$controller, $method], $this->matches);
    }
  }

  public function with(string $param, string $regex) :self {
    $this->params[$param] = str_replace('(', '(?:', $regex);
    return $this;
  }

  public function getUrl(array $params) :string {
    $path = $this->path;
    foreach ($params as $key => $value) {
      $path = str_replace(":$key", $value, $path);
    }
    return "/$path";
  }

  private function paramMatch(array $match) :string {
    if (isset($this->params[$match[1]])) {
      return '(' . $this->params[$match[1]] . ')';
    }
    return '([^/]+)';
  }

}
