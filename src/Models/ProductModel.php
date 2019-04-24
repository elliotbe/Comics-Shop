<?php
declare(strict_types = 1);
namespace App\Models;

class ProductModel extends Model {

  protected $table = 'product_view';

  public function insert(array $data) {
    $product_stmt =
    "INSERT INTO product SET
      ref = :ref, title = :title,
      price_supplier = :price_supplier, price = :price,
      author_id = (SELECT id FROM author WHERE content = :author),
      category_id = (SELECT id FROM category WHERE content = :category),
      hero_id = (SELECT id FROM hero WHERE content = :hero),
      editor_id = (SELECT id FROM editor WHERE content = :editor),
      supplier_id = (SELECT id FROM supplier WHERE content = :supplier),
      ref_editor = :ref_editor, ref_supplier = :ref_supplier, synopsis = :synopsis
    ";
    try {
      $this->db->getPdo()->beginTransaction();
      $this->insertIgnore('author', $data['author']);
      $this->insertIgnore('category', $data['category']);
      $this->insertIgnore('hero', $data['hero']);
      $this->insertIgnore('editor', $data['editor']);
      $this->insertIgnore('supplier', $data['supplier']);
      $this->db->query($product_stmt, $data);
      $this->db->getPdo()->commit();
    } catch (\Exception $e) {
      $this->db->getPdo()->rollBack();
      throw $e;
    }
  }

  private function insertIgnore(string $table, ?string $attribute) :void {
    if (is_null($attribute)) {
      return;
    }
    $id = $this->db->query("SELECT id FROM $table WHERE content = ?", [$attribute])->fetchColumn();
    if ($id === false) {
      $this->db->query("INSERT INTO $table SET content = ?", [$attribute]);
    }
  }

}
