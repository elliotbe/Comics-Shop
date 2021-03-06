<?php
declare(strict_types = 1);
namespace App\Entity;

class CategoryEntity extends Entity {

  public function getSlug() :string {
    return slugify($this->content);
  }

  public function getUrl() :string {
    return generateUrl('Product#byColumn', [
      'column' => 'category',
      'id' => $this->category_id,
      'slug' => slugify($this->content)
    ]);
  }

  /** @var int $category_id */
  public $category_id;

  /** @var string $content */
  public $content;

}
