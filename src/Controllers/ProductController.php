<?php
namespace App\Controllers;

class ProductController extends Controller {

  public function home() {
    $foo = 'foo';
    $bar = 'bar';
    $this->render('home', compact($foo, $bar));
  }

  public function byColumn() {
    return 'byColumn';
  }

  public function modalContent() {
    return 'modal';
  }

}
