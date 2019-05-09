<?php
declare(strict_types = 1);
namespace App\Controller;

use App\Pager;

class ProductController extends Controller {

  public function __construct() {
    parent::__construct();
    $this->loadModel('Product');
  }

  public function all() {
    $products = $this->Product->getAll();
    $number_of_page = $this->Product->getNumberOfPage();
    $pager = new Pager($number_of_page);
    $this->render('home', compact('products', 'pager'));
  }

  public function modal(int $id) {
    $product = $this->Product->getOne($id);
    require($this->view_path . "/modal.php");
  }

  public function byColumn(string $column, int $id) {
    $products = $this->Product->getAllByColumn($column, $id);
    $number_of_page = $this->Product->getNumberOfPage($column, $id);
    $pager = new Pager($number_of_page);
    $page_title = capitalize($products[0]->$column);
    $main_title = $column === 'category' ? null : $page_title;
    $this->render('home', compact('products', 'pager', 'main_title'), $page_title);
  }

}
