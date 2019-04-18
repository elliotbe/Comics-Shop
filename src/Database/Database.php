<?php
namespace App\Database;

use \PDO;


class Database {

  protected $pdo;

  public function __construct($host, $dbname, $username, $password) {
    if (is_null($dbname)) {
      $dsn = "mysql:host=$host;dbname=$dbname;port=3306;charser=utf8mb4";
    } else {
      $dsn = "mysql:host=$host;port=3306;charser=utf8mb4";
    }

    try {
      $this->pdo = new PDO($dsn, $username, $password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
  }

  public function query($statement, $params = null, $class_name = null) :\PDOStatement {
    $req = $this->pdo->prepare($statement);
    if ($class_name) {
      $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
    } else {
      $req->setFetchMode(PDO::FETCH_OBJ);
    }
    $req->execute($params);
    return $req;
  }

  public function lastId() :string {
    return $this->pdo->lastInsertId();
  }

}
