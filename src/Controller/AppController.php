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
    // $product = \App::getModel('Product')->getOne(492);
    $this->render('sandbox',[], 'Sandbox', 'pre');
  }

  public function fourOhFour() {
    $error_msg = "Cette page n'a pas encore été créée.";
    $categories = $this->Category->getAll();
    header('HTTP/1.1 404 Not Found');
    $this->render('error', compact('categories', 'error_msg'), 'Page non trouvée');
  }

}
