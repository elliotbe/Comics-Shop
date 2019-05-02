<?php
declare(strict_types = 1);
namespace App\Database;

class DatabaseSchema extends Database {

  public function createDatabase(string $db_name) :\PDOStatement {
    $stmt = "CREATE DATABASE IF NOT EXISTS `$db_name` COLLATE 'utf8mb4_general_ci'";
    return $this->query($stmt);
  }

  public function addTable(string $table_name, array $columns = []) :\PDOStatement {
    $stmt = "CREATE TABLE IF NOT EXISTS `$table_name` ( ";
    if (empty($columns)) {
      $columns[] = $this->addColumn('id', 'INT', null, 'AUTO_INCREMENT PRIMARY KEY');
    }
    foreach ($columns as $column) {
      $stmt .=  "$column, ";
    }
    $stmt = substr($stmt, 0, strlen($stmt) - 2);
    $stmt .= " )";
    return $this->query($stmt);
  }

  public function addForeignKey(
    string $key_name, string $table_name,
    string $on_delete = 'RESTRICT', string $on_update = 'RESTRICT'
  ) :\PDOStatement {
    $parent_column = "{$key_name}_id";
    return $this->query(
    "ALTER TABLE `$table_name`
      ADD FOREIGN KEY (`$parent_column`) REFERENCES `$key_name` (`id`)
      ON DELETE $on_delete ON UPDATE $on_update
  ");
  }

  public function addColumn(
    string $column_name, string $type,
    string $length = null, string $options = null
  ) :string {
    $stmt_part = "$column_name $type";
    if ($length) {
      $stmt_part .= "($length)";
    }
    if ($options) {
      $stmt_part .= " $options";
    }
    return $stmt_part;
  }

}
