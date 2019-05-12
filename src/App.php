<?php
declare(strict_types = 1);

use App\Auth;
use App\Basket;
use App\Session;
use App\Mailer;
use App\Config\Config;
use App\Model\Model;
use App\Database\Database;

class App {

  private static $config;
  private static $database;
  private static $session;
  private static $auth;
  private static $basket;
  private static $mailer;

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
      self::$config = new Config(['.env', '.env.local']);
    }
    return self::$config;
  }


  public static function auth() :Auth {
    if (is_null(self::$auth)) {
      self::$auth = new Auth(
        self::getModel('User'), self::session(), self::basket(), self::mailer()
      );
    }
    return self::$auth;
  }


  public static function basket() :Basket {
    if (is_null(self::$basket)) {
      self::$basket = new Basket(self::getModel('Product'), self::getModel('Basket'));
    }
    return self::$basket;
  }


  public static function mailer() :Mailer {
    if (is_null(self::$mailer)) {
      self::$mailer = new Mailer(true);
    }
    return self::$mailer;
  }


  public static function getModel(string $model_name) :Model {
    $model = 'App\\Model\\' . ucfirst($model_name) . 'Model';
    return new $model(App::database());
  }

}
