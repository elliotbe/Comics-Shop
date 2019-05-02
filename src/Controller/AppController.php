<?php
declare(strict_types = 1);
namespace App\Controller;

class AppController extends Controller {

  public function __construct() {
    $this->loadModel('Category');
  }

  public function initialize() {
    ob_start();
    require(ROOT . '/extra/init-db.php');
    $page_name = \setPageName('Initialize database');
    $page_content = ob_get_clean();
    require($this->template_path . "/pre.php");
  }

  public function sandbox() {
    $test_query = \App::database()->query("SELECT IF(:synopsis IS NOT NULL, :synopsis, 'DEFAULT')", ['synopsis' => null]); // condition 2 si faux
    $this->render('sandbox', compact('test_query'), 'Sandbox', 'pre');
  }

  public function fourOhFour() {
    $error_msg = "Cette page n'a pas encore été créée.";
    $categories = $this->Category->getAll();
    header('HTTP/1.1 404 Not Found');
    $this->render('error', compact('categories', 'error_msg'), 'Page non trouvée');
  }

}
