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
      self::$auth = new Auth();
    }
    return self::$auth;
  }

  public static function basket() :Basket {
    if (is_null(self::$basket)) {
      self::$basket = new Basket(self::auth(), self::session(), self::getModel('Product'), self::getModel('Basket'));
    }
    return self::$basket;
  }

  public static function getModel(string $model_name) :Model {
    $model = 'App\\Model\\' . ucfirst($model_name) . 'Model';
    return new $model(App::database());
  }

}
