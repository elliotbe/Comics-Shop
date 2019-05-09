<?php
declare(strict_types = 1);
namespace App\Model;

use App\Database\Database;
use App\Entity\Entity;


class ProductModel extends Model {

  private $products_per_page = 20;
  private $offset;
  protected $table = 'product_view';

  public function __construct(Database $db) {
    parent::__construct($db);
    $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page_number < 1) {
      $page_number = 1;
    }
    $this->offset = $this->products_per_page * ($page_number - 1);
  }

  public function getAll() :array {
    return $this->queryModel(
      "SELECT * FROM $this->table LIMIT $this->offset, $this->products_per_page"
    )->fetchAll();
  }

  public function getAllByColumn(string $column, int $id) :array {
    $column = escapeSQL("{$column}_id");
    return $this->queryModel(
      "SELECT * FROM $this->table
        WHERE $column = :id
        LIMIT $this->offset, $this->products_per_page
      ",
      ['id' => $id]
    )->fetchAll();
  }

  public function getNumberOfPage(string $column = null, int $id = null) :int {
    if ($column) {
      $column = escapeSQL("{$column}_id");
      $item_count = $this->queryModel(
        "SELECT COUNT(product_id) FROM $this->table WHERE $column = :id",
        ['id' => $id]
      )->fetchColumn();
    } else {
      $item_count = $this->queryModel(
        "SELECT COUNT(product_id) FROM $this->table"
      )->fetchColumn();
    }
    return (int)ceil($this->number_of_page = $item_count / $this->products_per_page);
  }

  public function getOne($id) :Entity {
    return $this->queryModel(
      "SELECT * FROM $this->table WHERE product_id = ? LIMIT 1",
      [$id]
    )->fetch();
  }

  public function insert(array $product_data) :\PDOStatement {
    try {
      $this->db->getPdo()->beginTransaction();
      $this->insertOrIgnore('author', $product_data['author']);
      $this->insertOrIgnore('category', $product_data['category']);
      $this->insertOrIgnore('hero', $product_data['hero']);
      $this->insertOrIgnore('editor', $product_data['editor']);
      $this->insertOrIgnore('supplier', $product_data['supplier']);
      $query = $this->queryModel(
        "INSERT INTO product SET
          ref = :ref, title = :title,
          price_supplier = :price_supplier, price = :price,
          author_id = (SELECT author_id FROM author WHERE content = :author),
          category_id = (SELECT category_id FROM category WHERE content = :category),
          hero_id = (SELECT hero_id FROM hero WHERE content = :hero),
          editor_id = (SELECT editor_id FROM editor WHERE content = :editor),
          supplier_id = (SELECT supplier_id FROM supplier WHERE content = :supplier),
          ref_editor = :ref_editor, ref_supplier = :ref_supplier, synopsis = :synopsis
        ", $product_data);
      $this->db->getPdo()->commit();
      return $query;
    } catch (\Exception $e) {
      $this->db->getPdo()->rollBack();
      throw $e;
    }
  }

  private function insertOrIgnore(string $table, ?string $attribute) :void {
    if ($attribute) {
      $id = $this->queryModel("SELECT {$table}_id FROM $table WHERE content = ?", [$attribute])->fetchColumn();
      if ($id === false) {
        $this->queryModel("INSERT INTO $table SET content = ?", [$attribute]);
      }
    }
  }



}
