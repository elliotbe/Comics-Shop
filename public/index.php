<?php
declare(strict_types=1);
if (!defined('ROOT')) {
  define('ROOT', dirname(__DIR__) . '/');
}

require('vendor/autoload.php');

use App\Router\Router;
use App\Router\RouterException;

// Register Whoops to pretty print error message
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Serve static files
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_cli_server = php_sapi_name() === 'cli-server';
$is_index = $url_path === '/';
if ($is_cli_server && file_exists(__DIR__ . $url_path) && $is_index === false) {
  return false;
}

// Or proceed normally
$router = new Router(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


$router->get('/', 'Product#all');
$router->get('/:column/:id-:slug', 'Product#byColumn')->with('id', '[0-9]+');
$router->get('/:id-:slug', 'Product#single')->with('id', '[0-9]+');

$router->get('/login', 'Product#all');
$router->get('/basket', 'Product#all');

$router->get('/sandbox', 'App#sandbox');
$router->get('/initialize', 'App#initialize');

$router->get('/:fourOhFour', 'App#fourOhFour')->with('fourOhFour', '.+');

$router->run();
