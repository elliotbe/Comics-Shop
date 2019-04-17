<?php
namespace App\Controllers;

class ProductController extends Controller {

  public function home() {
    $this->render('home');
  }

  public function byColumn() {
    echo 'byColumn' . '<br>';
    echo '<a href="/">home</a>';
  }

  public function modalContent() {
    return 'modal';
  }

}
