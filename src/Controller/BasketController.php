<?php
declare(strict_types = 1);
namespace App\Controller;

class BasketController extends Controller {

  private $basket;

  public function show() {
    $basket_data = \App::basket()->getBasketProductInfo();
    $total_price = array_reduce($basket_data, function ($total, $product) {
      return $total += $product->quantity * $product->price;
    }, 0);
    $total_price = parseFloat($total_price) . '€';
    $this->render('basket', compact('basket_data', 'total_price'), 'Mon Panier');
  }

  public function add(int $id) {
    \App::basket()->addToBasket($id);
    \App::session()->setFlash('success', "L'article à bien été ajouté.");
    sendBack();
  }

  public function remove(int $id) {
    \App::basket()->removeFromBasket($id);
    sendBack();
  }

  public function delete(int $id) {
    \App::basket()->deleteFromBasket($id);
    sendBack();
  }

}
