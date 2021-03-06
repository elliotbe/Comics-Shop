<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Model\Model;


class Controller {

  protected $view_path = ROOT . '/src/View';
  protected $template_path = ROOT . '/src/View/template';

  public function __construct() {
    \App::auth()->connectFromCookie();
  }

  public function render(
    string $file_name, array $params = [],
    string $page_name = null, string $template_name = 'default'
  ) :void {
    extract($params);
    $categories = $this->loadModel('Category')->getAll();
    $flash_message = \App::session()->getFlash();
    ob_start();
    require($this->view_path . "/$file_name.php");
    $page_content = ob_get_clean();
    require($this->template_path . "/$template_name.php");
    \App::session()->removeFlash();
  }

  protected function loadModel($model_name) :Model {
    $this->$model_name = \App::getModel($model_name);
    return $this->$model_name;
  }

}
