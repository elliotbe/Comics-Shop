<?php
declare(strict_types = 1);
namespace App\Model;

use App\Database\Database;
use App\Entity\Entity;


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

  public function getAll() :array {
    return $this->queryModel("SELECT * FROM $this->table ORDER BY id")->fetchAll();
  }

  public function getOne($id) :Entity {
    return $this->queryModel(
      "SELECT * FROM $this->table WHERE id = ? LIMIT 1",
      [$id]
    )->fetch();
  }

  public function upsert(array $fields, string $id = null) :\PDOStatement {
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

  protected function queryModel($statement, $params = null) :\PDOStatement {
    $entity = explode('\\', get_called_class());
    $entity = str_replace('Model', 'Entity', end($entity));
    return $this->db->query($statement, $params, 'App\\Entity\\' . $entity);
  }

  protected function escapeSql(string $string) :string {
    return $string;
  }

}
