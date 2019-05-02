<?php
declare(strict_types = 1);
namespace App\Entity;

class CategoryEntity extends Entity {

  /** @var int $îd */
  public $id;

  /** @var string $content */
  public $content;

  public function __construct() {
    $this->content = \capitalize($this->content);
  }

  public function getSlug() :string {
    return slugify($this->content);
  }

}
