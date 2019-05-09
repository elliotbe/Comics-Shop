<?php
declare(strict_types = 1);
namespace App\Router;

class Router {

  private $url;
  private $routes = [];
  private $named_routes = [];

  public function __construct(string $url) {
    $this->url = $url;
  }

  public function get(string $path, $callback, string $name = null) :Route {
    return $this->add($path, $callback, $name, 'GET');
  }

  public function post(string $path, $callback, string $name = null) :Route {
    return $this->add($path, $callback, $name, 'POST');
  }

  public function add(string $path, $callback, ?string $name, string $method) :Route {
    $route = new Route($path, $callback);
    $this->routes[$method][] = $route;

    if (is_string($callback) && is_null($name)) {
      $name = $callback;
    }

    if ($name) {
      $this->named_routes[$name] = $route;
    }

    return $route;
  }

  public function run() {
    if (isset($this->routes[$_SERVER['REQUEST_METHOD']]) === false) {
      throw new RouterException("{$_SERVER['REQUEST_METHOD']} method does not exist", 1);
    }

    foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
      if ($route->match($this->url)) {
        return $route->call();
      }
    }

    throw new RouterException('No matching routes', 2);
  }

  public function url (string $name, array $params = []) :string {
    if (isset($this->named_routes[$name]) === false) {
      throw new RouterException("No route matching this name '$name'", 3);
    }

    return $this->named_routes[$name]->getUrl($params);
  }

}
