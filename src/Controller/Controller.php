<?php
declare(strict_types = 1);
namespace App\Controller;

class Controller {

  protected $view_path = ROOT . '/src/View';
  protected $template_path = ROOT . '/src/View/template';
  protected $model_name;

  protected function render(
    string $file_name, array $params = [],
    string $page_name = null, string $template_name = 'default'
  ) :void {
    extract($params);
    ob_start();
    require($this->view_path . "/$file_name.php");
    $page_content = ob_get_clean();
    require($this->template_path . "/$template_name.php");
  }

  protected function loadModel($model_name) {
    $this->$model_name = \App::getModel($model_name);
  }



}
