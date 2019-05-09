<?php
declare(strict_types = 1);
namespace App\Controller;

class AppController extends Controller {

  public function initialize() {
    ob_start();
    require(ROOT . '/extra/init-db.php');
    $page_name = \setPageName('Initialize database');
    $page_content = ob_get_clean();
    require($this->template_path . "/blank.php");
  }

  public function sandbox() {
    $this->render('sandbox', [], 'Sandbox', 'blank');
  }

  public function fourOhFour() {
    $error_msg = "Cette page n'a pas encore été créée.";
    header('HTTP/1.1 404 Not Found', true, 404);
    $this->render('error', compact('error_msg'), 'Page non trouvée');
  }

}
