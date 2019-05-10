<?php
declare(strict_types = 1);

use App\Database\Database;
use App\Session;
use App\Config\Config;
use App\Model\Model;
use App\Auth;
use App\Basket;

class App {

  private static $config;
  private static $database;
  private static $session;
  private static $auth;
  private static $basket;

  public static function database() :Database {
    if (is_null(self::$database)) {
      self::$database = new Database(
        App::config()->get('DB_HOST'), App::config()->get('DB_NAME'),
        App::config()->get('DB_USER'), App::config()->get('DB_PASS'),
      );
    }
    return self::$database;
  }

  public static function session() :Session {
    if (is_null(self::$session)) {
      self::$session = new Session();
    }
    return self::$session;
  }

  public static function config() :Config {
    if (is_null(self::$config)) {
      self::$config = new Config(['.env']);
    }
    return self::$config;
  }

  public static function auth() :Auth {
    if (is_null(self::$auth)) {
      self::$auth = new Auth(self::session());
    }
    return self::$auth;
  }

  public static function basket() :Basket {
    if (is_null(self::$basket)) {
      $product_model = self::getModel('Product');
      $basket_model = self::getModel('Basket');
      self::$basket = new Basket($product_model, $basket_model);
    }
    return self::$basket;
  }

  public static function getModel(string $model_name) :Model {
    $model = 'App\\Model\\' . ucfirst($model_name) . 'Model';
    return new $model(App::database());
  }

}
