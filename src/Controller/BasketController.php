<?php
declare(strict_types = 1);
namespace App\Controller;

use App\HTML\Form;

class BasketController extends Controller {

  private $basket;
  private $session;

  public function __construct() {
    parent::__construct();
    $this->basket = \App::basket();
    $this->session = \App::session();
    $this->loadModel('Order');
  }


  /**
   * @route '/mon-panier'
   */

  public function show() {
    $basket_data = $this->basket->getBasketProductInfo();
    $total_price = array_reduce($basket_data, function ($total, $product) {
      return $total += $product->quantity * $product->price;
    }, 0);
    $total_price = parseFloat($total_price) . '€';
    $this->render('basket/basket', compact('basket_data', 'total_price'), 'Mon Panier');
  }


  /**
   * @route '/commander'
   */

  public function order() {
    \App::auth()->restrict();
    $basket_data = $this->basket->getBasketProductInfo();
    $total_price = array_reduce($basket_data, function ($total, $product) {
      return $total += $product->quantity * $product->price;
    }, 0);
    $total_price = parseFloat($total_price) . '€';
    $form = new Form($this->session->get('auth'));
    $this->render('basket/order', compact('basket_data', 'total_price', 'form'), 'Commander');
  }


  /**
   * @route '/payer-ma-commande'
   */

  public function confirmOrder() {
    \App::auth()->restrict();
    $basket_data = $this->basket->getBasketProductInfo();
    $total_price = array_reduce($basket_data, function ($total, $product) {
      return $total += $product->quantity * $product->price;
    }, 0);
    $total_price = (float)sprintf('%0.2f', $total_price);
    $user_id = $this->session->get('auth')['user_id'];
    $order_id = $this->Order->queryModel(
      "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'order'
    ")->fetchColumn();
    // dump(sprintf('%08d', $order_id));
    // dd();
    $this->Order->upsert([
        'user_id' => $user_id,
        'total_amount' => $total_price,
        'order_number' => $order_id,
    ]);
    $this->Order->queryModel(
      "INSERT INTO order_item (order_id, product_id, quantity)
        SELECT '$order_id', basket.product_id, basket.quantity
        FROM basket WHERE user_id = $user_id
    ")->rowCount();
    $this->session->setFlash('success', 'Votre commande a été validé.');
    $this->basket->eraseBasket();
    redirect('/');
    // $this->render('basket/confirm-order', [], 'Confirmer ma commande');

    // if (comfirmedPayement()) {
    //   $this->Order->generateOrder($user_id);
    // }
  }


  /**
   * @route '/mon-panier/ajouter-[:id]'
   * @param integer $id
   */

  public function add(int $id) {
    $this->basket->addToBasket($id);
    $this->session->setFlash('success', "L'article à bien été ajouté.");
    sendBack();
  }


  /**
   * @route '/mon-panier/retier-[:id]'
   * @param integer $id
   */

  public function remove(int $id) {
    $this->basket->removeFromBasket($id);
    sendBack();
  }


  /**
   * @route '/mon-panier/supprimer-[:id]'
   * @param integer $id
   */

  public function delete(int $id) {
    $this->basket->deleteFromBasket($id);
    sendBack();
  }

}
