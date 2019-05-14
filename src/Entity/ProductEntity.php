<?php
declare(strict_types = 1);
namespace App\Entity;

class ProductEntity extends Entity {

  private $translation  = [
    'author' => 'auteur',
    'category' => 'catégorie',
    'hero' => 'héro',
    'editor' => 'éditeur',
  ];

  public function __construct() {
    $this->synopsis ?? $this->synopsis = 'Pas de résumé disponible.';
  }

  public function getSlug() :string {
    return slugify($this->title);
  }

  public function getImgSrc() :string {
    $img_folder = array_slice(scandir(ROOT . 'public/img/product/'), 2);
    $file_name = mb_strtolower($this->ref) . '.jpg';
    $img_src = array_reduce($img_folder, function ($carry, $item) use ($file_name) {
      $item === $file_name ? $carry = "/img/product/$file_name" : null;
      return $carry;
    }, '/img/product/default.jpg');
    return $img_src;
  }

  public function getTitleClassName() :string {
    if (mb_strlen($this->title) <= 22) {
      return 'thumbnail__title';
    }
    return 'thumbnail__title small';
  }

  public function getOrderIsDisabled() :?string {
    if (is_null($this->price)) {
      return 'disabled';
    }
    return null;
  }

  public function getParsedPrice() :string {
    if (is_null($this->price)) {
      return 'Pas en stock';
    }
    $price = parseFloat((float)$this->price);
    return "{$price}€";
  }

  public function getModalUrl() :string {
    return generateUrl('Product#modal', [ 'id' => $this->product_id ]);
  }

  public function fieldNotNull(string $field, string $delimiter = 'div', bool $is_link = true) {
    if (isset($this->$field)) {
      $field_id = $field . '_id';
      $label = $this->translation[$field];
      if ($is_link) {
        $link_url = generateUrl('Product#byColumn', [
          'column' => $field,
          'id' => $this->$field_id,
          'slug' => slugify($this->$field)
        ]);
        return "<$delimiter class=\"modal__data\">$label : <a class=\"modal__link\" href=\"$link_url\">{$this->$field}</a></$delimiter>";
      }
      return "<$delimiter class=\"basket-item__data\">$label : <strong class=\"strong\">{$this->$field}</strong></$delimiter>";
    }
  }



  /** @var int $product_id */
  public $product_id;

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

  /** @var int|null $quantity */ // Added by the basket controller;
  public $quantity;

}
