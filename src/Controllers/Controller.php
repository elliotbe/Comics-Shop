<?php
namespace App\Controllers;

class Controller {

  private $views_path = ROOT . '/src/Views/';

  protected function render(string $filename, array $params = []) {
    extract($params);
    ob_start();
    require($this->views_path . $filename . '.php');
    $page_content = ob_get_clean();
    require($this->views_path . "template/default.php");
  }

  public function initDB() {
    ob_start();
    require(ROOT . '/extra/init-db.php');
    $page_content = ob_get_clean();
    require($this->views_path . "template/pre.php");
  }

}
