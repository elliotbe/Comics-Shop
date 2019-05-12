<?php
declare(strict_types = 1);
namespace App;

use App\Model\ProductModel;
use App\Model\BasketModel;


class Basket {

  private $product_model;
  private $basket_model;
  public $basket_data;


  public function __construct(ProductModel $product_model, BasketModel $basket_model) {
    $this->product_model = $product_model;
    $this->basket_model = $basket_model;
    $this->basket_data = \App::session()->get('basket') ?? [];
  }


  public function __destruct() {
    \App::session()->set('basket', $this->basket_data);
    if (\App::auth()->isLoggedIn()) {
      $basket_data = $this->basket_data;
      $basket_db = $this->getBasketFromDb();
      sort($basket_data); sort($basket_db);
      if ($basket_data !== $basket_db) {
        $this->basket_model->delete(\App::auth()->getUserId(), 'user');
        foreach ($this->getBasketQtty() as $product_id => $qtty) {
          $this->basket_model->upsert([
            'user_id' => \App::auth()->getUserId(),
            'product_id' => $product_id,
            'quantity' => $qtty
          ]);
        }
      }
    }
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
     $this->basket_data = $this->getBasketFromDb();
   }


   public function mergeBasketFromDb() :void {
    $this->basket_data = array_merge($this->basket_data, $this->getBasketFromDb());
   }

   public function eraseBasket() :void {
     $this->basket_data = [];
   }


  private function getBasketQtty() :array {
    return array_reduce($this->basket_data, function ($array, $id) {
      isset($array[$id]) ? $array[$id]++ : $array[$id] = 1;
      return $array;
    }, []);
  }


  private function getBasketFromDb() :array {
    $data = $this->basket_model->getByUser(\App::auth()->getUserId());
    $basket_db = [];
    foreach ($data as $product) {
      $to_push = array_fill(0, (int)$product->quantity, (int)$product->product_id);
      $basket_db = array_merge($basket_db, $to_push);
    }
    return $basket_db;
  }





}
