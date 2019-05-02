<?php
declare(strict_types = 1);
namespace App\Entity;

class ProductEntity extends Entity {

  public function __construct() {
    array_map(function ($field) {
      $this->$field !== null ? $this->$field = capitalize($this->$field) : null;
    }, ['title', 'author', 'category', 'hero', 'editor', 'supplier']);

    $this->synopsis ?? $this->synopsis = 'Pas de résumé disponible.';
  }

  public function getSlug() :string {
    return slugify($this->title);
  }

  public function getImgSrc() :string {
    $img_folder = array_slice(scandir(ROOT . 'public/img/product/'), 2);
    $file_name = strtolower($this->ref) . '.jpg';
    $img_src = array_reduce($img_folder, function ($carry, $item) use ($file_name) {
      $item === $file_name ? $carry = "/img/product/$file_name" : null;
      return $carry;
    }, '/img/product/default.jpg');
    return $img_src;
  }


  /** @var int $id */
  public $id;

  /** @var string $ref */
  public $ref;

  /** @var string $title */
  public $title;

  /** @var float|null $price_supplier */
  public $price_supplier;

  /** @var float|null $price */
  public $price;

  /** @var int|null $author_id */
  public $author_id;

  /** @var string|null $author */
  public $author;

  /** @var int|null $category_id */
  public $category_id;

  /** @var string|null $category */
  public $category;

  /** @var int|null $hero_id */
  public $hero_id;

  /** @var string|null $hero */
  public $hero;

  /** @var int|null $editor_id */
  public $editor_id;

  /** @var string|null $editor */
  public $editor;

  /** @var int $supplier_id */
  public $supplier_id;

  /** @var string|null $supplier */
  public $supplier;

  /** @var string|null $ref_editor */
  public $ref_editor;

  /** @var string|null $ref_supplier */
  public $ref_supplier;

  /** @var string|null $synopsis */
  public $synopsis;

}
