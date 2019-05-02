<?php
declare(strict_types = 1);
namespace App\Entity;

class ProductEntity extends Entity {

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

  /** @var string $synopsis */
  public $synopsis;

  public function getImg() :string {
    return 'I\'m a beautiful img, I swear !';
  }

  public function getSlug() :string {
    return slugify($this->title);
  }

}
