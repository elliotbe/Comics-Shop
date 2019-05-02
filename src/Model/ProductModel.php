<?php
declare(strict_types = 1);
namespace App\Model;

use App\Database\Database;


class ProductModel extends Model {

  private $limit;
  private $offset;
  protected $table = 'product_view';

  public function __construct(Database $db) {
    parent::__construct($db);
    $this->limit = \App::config()->get('PRODUCTS_PER_PAGE');
    $page_number = $_GET['page'] ?? 1;
    if ($page_number < 1) {
      $page_number = 1;
    }
    $this->offset = $this->limit * ((int)$page_number - 1);
  }

  public function getAll() :array {
    return $this->queryModel(
      "SELECT * FROM $this->table LIMIT $this->offset, $this->limit"
    )->fetchAll();
  }

  public function getAllByColumn(string $column, int $id) :array {
    $column = "{$column}_id";
    return $this->queryModel(
      "SELECT * FROM $this->table
        WHERE `$column` = :id
        LIMIT $this->offset, $this->limit
      ",
      ['id' => $id]
    )->fetchAll();
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
          author_id = (SELECT id FROM author WHERE content = :author),
          category_id = (SELECT id FROM category WHERE content = :category),
          hero_id = (SELECT id FROM hero WHERE content = :hero),
          editor_id = (SELECT id FROM editor WHERE content = :editor),
          supplier_id = (SELECT id FROM supplier WHERE content = :supplier),
          ref_editor = :ref_editor, ref_supplier = :ref_supplier,
          synopsis = IF(:synopsis IS NOT NULL, :synopsis, DEFAULT(synopsis))
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
      $id = $this->queryModel("SELECT id FROM $table WHERE content = ?", [$attribute])->fetchColumn();
      if ($id === false) {
        $this->queryModel("INSERT INTO $table SET content = ?", [$attribute]);
      }
    }
  }

  private function getPage(?int $page_number) {

  }

}
