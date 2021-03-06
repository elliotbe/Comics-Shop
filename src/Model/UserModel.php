<?php
declare(strict_types = 1);
namespace App\Model;

class UserModel extends Model {

  /**
   * Return a single row from the user table by email
   * @param string $email
   * @return UserEntity|false
   */

  public function getByEmail(string $email) {
    return $this->queryModel(
      "SELECT * FROM $this->table WHERE email = ? LIMIT 1", [$email]
    )->fetch();
  }


  /**
   * Return the user_id of the last user inserted into the database
   * @return integer
   */

  public function getLastId() :int {
    return $this->db->lastId();
  }


}
