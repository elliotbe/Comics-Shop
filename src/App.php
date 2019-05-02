<?php
use App\Database\Database;
use App\Session;
use App\Config\Config;
use App\Model\Model;

class App {

  public static $site_name = 'BD Shop';
  private static $instance;
  private static $config;
  private static $database;
  private static $session;

  public static function init() :App {
    if (is_null(self::$instance)) {
      self::$instance = new App();
    }
    return self::$instance;
  }

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

  public static function getModel(string $model_name) :Model {
    $model = 'App\\Model\\' . ucfirst($model_name) . 'Model';
    return new $model(App::database());
  }

}
