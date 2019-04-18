<?php
declare(strict_types=1);
define('ROOT', dirname(__DIR__) . '/');

require('vendor/autoload.php');

use App\Controllers\ProductController;
use App\Router\Router;

// Register Whoops to pretty print error message
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Serve static files
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_cli_server = php_sapi_name() === 'cli-server';
$is_index = $url_path === '/' || $url_path === '/index.php';
if ($is_cli_server && file_exists(__DIR__ . $url_path) && $is_index === false) {
  return false;
}

// Or proceed normally
$router = new Router(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$router->get('/', 'Product#home');
$router->get('/posts/:id-:slug', 'Product#byColumn')->with('id', '[0-9]+')->with('slug', '[a-z0-9-]+');

$router->run();
