<?php
declare(strict_types = 1);
namespace App\Controller;


class ProductController extends Controller {

  private $categories;

  public function __construct() {
    $this->loadModel('Product');
    $this->loadModel('Category');
    $this->categories = $this->Category->getAll();
  }

  public function all() {
    $products = $this->Product->getAll();
    $categories = $this->Category->getAll();
    $this->render('home', compact('products', 'categories'));
  }

  public function single(int $id) {
    $product = $this->Product->getOne($id);
    $categories = $this->Category->getAll();
    $this->render('single', compact('product', 'categories'));
  }

  public function byColumn(string $column, int $id) {
    $categories = $this->Category->getAll();
    try {
      $products = $this->Product->getAllByColumn($column, $id);
      $page_title = capitalize($products[0]->$column);
      $main_title = $column === 'category' ? null : $page_title;
      $this->render('home', compact('products', 'categories', 'main_title'), $page_title);
    } catch (\Exception $e) {
      // $error_msg =  "Il n'y a rien ici, obsolument rien.";
      $error_msg = $e->getMessage();
      header('HTTP/1.1 500 Internal Server Error');
      $this->render('error', compact('categories', 'error_msg'), 'Erreur');
    }
  }

}
