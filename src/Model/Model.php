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
    $table = mb_strtolower(str_replace('Model', '', end($table)));
    if (is_null($this->table)) {
      $this->table = $table;
    }
    $this->db = $db;
  }

  public function getAll() :array {
    return $this->queryModel("SELECT * FROM $this->table ORDER BY {$this->table}_id")->fetchAll();
  }


  /**
   * Return a single row from the database by id
   * @param integer $id
   * @return Entity|false
   */

  public function getOne(int $id) {
    return $this->queryModel(
      "SELECT * FROM $this->table WHERE {$this->table}_id = ? LIMIT 1",
      [$id]
    )->fetch();
  }

  public function upsert(array $params, int $id = null) :\PDOStatement {
    $stmt_part = $this->getPlaceholders($params);
    if ($id) {
      $params['id'] = $id;
      return $this->db->query("UPDATE $this->table SET $stmt_part WHERE {$this->table}_id = :id", $params);
    }
    return $this->db->query("INSERT INTO $this->table SET $stmt_part", $params);
  }

  public function delete(int $id, string $key_name = null) {
  if (is_null($key_name)) {
    $key_name = $this->table;
  }
  return $this->db->query("DELETE FROM $this->table WHERE {$key_name}_id = :id", ['id' => $id]);
  }

  protected function queryModel($statement, $params = null) :\PDOStatement {
    $entity = explode('\\', get_called_class());
    $entity = str_replace('Model', 'Entity', end($entity));
    return $this->db->query($statement, $params, 'App\\Entity\\' . $entity);
  }

  protected function getPlaceholders(array $params) :string {
    $stmt_part = array_reduce(array_keys($params), function ($init, $field) use ($params) {
      $init[] = "$field = :$field";
      return $init;
    }, []);
    return implode(', ', $stmt_part);
  }


}
