<?php
declare(strict_types = 1);
namespace App\Controller;

class BasketController extends Controller {

  public function show() {
    return 'show basket';
  }

  public function add() {
    return 'add to basket';
  }

  public function remove() {
    return 'remove from basket';
  }

  public function delete() {
    return 'delete from basket';
  }

}
