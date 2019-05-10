<?php
declare(strict_types=1);
if (!defined('ROOT')) {
  define('ROOT', dirname(__DIR__) . '/');
}

require('vendor/autoload.php');

use App\Router\Router;

// Register Whoops to pretty print error message
if (App::config()->get('ENV') === 'development') {
  $whoops = new \Whoops\Run;
  $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler());
  $whoops->register();
}

// Serve static files
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_cli_server = php_sapi_name() === 'cli-server';
$is_index = $url_path === '/';
if ($is_cli_server && file_exists(__DIR__ . $url_path) && $is_index === false) {
  return false;
}

// App::auth()->logout();
//  if (App::auth()->isLoggedIn()) {
//    sendBack();
//  }
// App::auth()->login(4);

// Or proceed normally
$router = new Router($_SERVER['REQUEST_URI']);

$router->get('/', 'Product#all');
$router->get('/modal/:id', 'Product#modal');
$router->get('/:column/:id-:slug', 'Product#byColumn')->with('id', '[0-9]+');

$router->get('/mon-panier', 'Basket#show');
$router->get('/mon-panier/ajouter-:id', 'Basket#add');
$router->get('/mon-panier/retirer-:id', 'Basket#remove');
$router->get('/mon-panier/supprimer-:id', 'Basket#delete');

// TODO
$router->get('/connexion', 'User#login');
$router->post('/connexion', 'User#login');

$router->get('/inscription', 'User#register');
$router->post('/inscription', 'User#register');

$router->get('/reset', 'User#passwordReset');
$router->get('/compte-utilisateur', 'User#accout');

// TODO
$router->get('/admin', 'Admin#dashboard');
$router->get('/admin/product', 'Admin#product');
$router->get('/admin/order', 'Admin#order');
$router->get('/admin/message', 'Admin#message');
$router->get('/admin/user', 'Admin#user');

// TODO remove it
$router->get('/sandbox', 'App#sandbox');
$router->post('/sandbox', 'App#sandbox');
$router->get('/initialize', 'App#initialize');

$router->get('/:fourOhFour', 'App#fourOhFour')->with('fourOhFour', '.+');

// TODO ykit
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
