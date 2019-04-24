<?php
namespace App\Models;

use PDOStatement;
use App\Database\Database;


class Model {

  protected $table;
  protected $db;

  public function __construct(Database $db) {
    $table = explode('\\', get_called_class());
    $table = strtolower(str_replace('Model', '', end($table)));
    if (is_null($this->table)) {
      $this->table = $table;
    }
    $this->db = $db;
  }

  public function all() :array {
    return $this->queryModel("SELECT * FROM $this->table")->fetchAll();
  }

  public function upsert(array $fields, string $id = null) :PDOStatement {
    $sql_parts = [];
    $attributes = [];
    foreach($fields as $k => $v) {
      $sql_parts[] = "$k = :$k";
      $attributes[$k] = $v;
    }
    $sql = implode(', ', $sql_parts);
    if ($id) {
      $attributes['id'] = $id;
      return $this->db->query("UPDATE $this->table SET $sql WHERE id = :id", $attributes);
    }
    return $this->db->query("INSERT INTO $this->table SET $sql", $attributes);
  }

  protected function queryModel($statement, $params = null) :PDOStatement {
    $entity = explode('\\', get_called_class());
    $entity = str_replace('Model', 'Entity', end($entity));
    return $this->db->query($statement, $params, 'App\\Entities\\' . $entity);
  }

}
