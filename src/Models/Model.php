<?php
namespace App\Models;

use App\Database;


class Model {

  protected $table;
  protected $db;

  public function __construct(Database $db) {
    $table = explode('\\', get_called_class());
    $table = strtolower(str_replace('Model', '', end($table)));
    $this->table = $table;
    $this->db = $db;
  }

  public function all() {
    return $this->queryModel("SELECT * FROM $this->table");
  }

  protected function queryModel($statement, $params = null) {
    $entity = explode('\\', get_called_class());
    $entity = str_replace('Model', 'Entity', end($entity));
    // dump($entity); die();

    return $this->db->query($statement, $params, 'App\\Entities\\' . $entity);
  }

}
