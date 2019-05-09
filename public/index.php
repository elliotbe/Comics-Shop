<?php
declare(strict_types=1);
if (!defined('ROOT')) {
  define('ROOT', dirname(__DIR__) . '/');
}

require('vendor/autoload.php');

// Register Whoops to pretty print error message
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use App\Router\Router;

if (App::config()->get('ENV') === 'development') {
  // Register Whoops to pretty print error message
  $whoops = new \Whoops\Run;
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
  $whoops->register();
}

// Serve static files
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_cli_server = php_sapi_name() === 'cli-server';
$is_index = $url_path === '/';
if ($is_cli_server && file_exists(__DIR__ . $url_path) && $is_index === false) {
  return false;
}

if (App::auth()->isLoggedIn()) {
  App::basket()->setBasketFromDb();
}
// App::auth()->logout();
// App::auth()->login(4);

// Or proceed normally
$router = new Router(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


$router->get('/', 'Product#all');
$router->get('/modal/:id', 'Product#modal');
$router->get('/:column/:id-:slug', 'Product#byColumn')->with('id', '[0-9]+');

$router->get('/mon-panier', 'Basket#show');

$router->get('/mon-panier/ajouter-:id', 'Basket#add');
$router->get('/mon-panier/retirer-:id', 'Basket#remove');
$router->get('/mon-panier/supprimer-:id', 'Basket#delete');
$router->get('/mon-panier/tout-supprimer', 'Basket#deleteAll');

$router->get('/sandbox', 'App#sandbox');
$router->get('/initialize', 'App#initialize');

$router->get('/:fourOhFour', 'App#fourOhFour')->with('fourOhFour', '.+');

if (App::config()->get('ENV') === 'development') {
  $router->run();
} else {
  try {
    $router->run();
  } catch (\Throwable $th) {
    $logger = new App\Logger('server_error.log');
    $logger->write($th);
    $error_msg = "Tous nos services sont mobilisés pour la résoudre dans les plus brefs délais.";
    header('HTTP/1.1 500 Internal Server Error', true, 500);
    $controller = new \App\Controller\Controller();
    $controller->render('error', compact('error_msg'), 'Erreur 500');
  }
}
