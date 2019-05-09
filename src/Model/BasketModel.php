<?php
declare(strict_types = 1);
namespace App\Model;

class BasketModel extends Model {

  public function getByUser(int $id) :array {
    return $this->db->query("SELECT * FROM $this->table WHERE user_id = :id", ['id' => $id])->fetchAll();
  }

}
