<?php
declare(strict_types = 1);
namespace App;



use App\Model\Model;

class Basket {

  private $auth;
  private $session;
  private $product_model;
  private $basket_model;
  private $basket_data;
  private $basket_db = [];
  private $user_id;

  public function __construct(Auth $auth, Session $session, Model $product_model, Model $basket_model) {
    $this->auth = $auth;
    $this->session = $session;
    $this->product_model = $product_model;
    $this->basket_model = $basket_model;
    $this->basket_data = $this->session->get('basket');

    if ($this->auth->isLoggedIn()) {
      $this->user_id = $this->auth->getUserId();
      $this->basket_db = $this->getBasketFromDb();
    }
  }

  public function __destruct() {
    $this->session->set('basket', $this->basket_data);
    if ($this->auth->isLoggedIn() && $this->basket_db !== $this->basket_data) {
      $this->basket_model->delete($this->user_id, 'user');
      foreach ($this->getBasketQtty() as $product_id => $qtty) {
        $this->basket_model->upsert([
          'user_id' => $this->user_id,
          'product_id' => $product_id,
          'quantity' => $qtty
          ]);
      }
    }
  }

  public function deleteBasket() :array {
    $this->basket_data = [];
    return $this->basket_data;
  }

  public function addToBasket(int $id) :array {
    $product = $this->product_model->getOne($id);
    if ($product->price <= 0) {
      throw new \Error("Product $id price invalid.", 1);
    }
    $this->basket_data[] = $id;
    return $this->basket_data;
  }

  public function removeFromBasket(int $id) :array {
    unset($this->basket_data[array_search($id, $this->basket_data)]);
    return $this->basket_data;
  }

  public function deleteFromBasket(int $id) :array {
    $this->basket_data = array_diff($this->basket_data, [$id]);
    return $this->basket_data;
  }

  public function getBasketProductInfo() :array {
    $basket_qtty = $this->getBasketQtty();
    return array_map(function ($id, $qtty) {
      $product = $this->product_model->getOne($id);
      $product->quantity = $qtty;
      return $product;
    }, array_keys($basket_qtty), $basket_qtty);
   }

   public function setBasketFromDb() :void {
     $this->basket_data = $this->basket_db;
   }

   public function mergeBasketFromDb() :void {
    $this->basket_data = array_merge($this->basket_data, $this->basket_db);
   }

  private function getBasketQtty() :array {
    return array_reduce($this->basket_data, function ($array, $id) {
      isset($array[$id]) ? $array[$id]++ : $array[$id] = 1;
      return $array;
    }, []);
  }

  private function getBasketFromDb() :array {
    $data = $this->basket_model->getByUser($this->user_id);
    $basket_db = [];
    foreach ($data as $product) {
      $to_push = array_fill(0, (int)$product->quantity, (int)$product->product_id);
      $basket_db = array_merge($basket_db, $to_push);
    }
    return $basket_db;
  }





}
