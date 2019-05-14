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
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
  $whoops->register();
}

// Serve static files
$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$is_cli_server = php_sapi_name() === 'cli-server';
$is_index = $url_path === '/';
if ($is_cli_server && file_exists(__DIR__ . $url_path) && $is_index === false) {
  return false;
}

// Or proceed normally
$router = new Router($_SERVER['REQUEST_URI']);


// Product Controller
$router->get('/', 'Product#all');
$router->get('/modal/:id', 'Product#modal');
$router->get('/:column/:id-:slug', 'Product#byColumn')->with('id', '[0-9]+');


// Basket Controller
$router->get('/mon-panier', 'Basket#show');
$router->get('/mon-panier/ajouter-:id', 'Basket#add');
$router->get('/mon-panier/retirer-:id', 'Basket#remove');
$router->get('/mon-panier/supprimer-:id', 'Basket#delete');

$router->get('/commander', 'Basket#order');
$router->post('/payer-ma-commande', 'Basket#confirmOrder');


// User controller
$router->get('/connexion', 'User#login');
$router->post('/connexion', 'User#login');

$router->get('/inscription', 'User#register');
$router->post('/inscription', 'User#register');

$router->get('/mon-compte', 'User#account');
$router->post('/mon-compte', 'User#account');

$router->get('/oubli-du-mot-de-passe', 'User#forgetPassword');
$router->post('/oubli-du-mot-de-passe', 'User#forgetPassword');

$router->get('/reinitialisation-du-mot-de-passe', 'User#resetPassword');
$router->post('/reinitialisation-du-mot-de-passe', 'User#resetPassword');

$router->post('/changer-de-mot-de-passe', 'User#changePassword');
$router->post('/supprimer-le-compte', 'User#suppressAccount');

$router->get('/confirmation', 'User#confirm');
$router->get('/renvoi-confirmation', 'User#resendConfirm');
$router->get('/deconnexion', 'User#logout');


// TODO
$router->get('/admin', 'Admin#dashboard');
$router->get('/admin/product', 'Admin#product');
$router->get('/admin/order', 'Admin#order');
$router->get('/admin/message', 'Admin#message');
$router->get('/admin/user', 'Admin#user');


// TODO remove it
// App Controller
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
