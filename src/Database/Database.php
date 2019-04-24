<?php
declare(strict_types = 1);
namespace App\Database;

use PDO;
use PDOStatement;
use PDOException;


class Database {

  protected $pdo;

  public function __construct(string $host, ?string $db_name, string $username, string $password) {
    if (is_null($db_name)) {
      $dsn = "mysql:host=$host;port=3306;charset=utf8mb4";
    } else {
      $dsn = "mysql:host=$host;dbname=$db_name;port=3306;charset=utf8mb4";
    }
    try {
      $this->pdo = new PDO($dsn, $username, $password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
  }

  public function __destruct() {
    $this->pdo = null;
  }

  public function getPdo() :PDO {
    return $this->pdo;
  }

  public function query($statement, $params = null, $class_name = null) :PDOStatement {
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
