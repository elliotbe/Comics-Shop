<?php
namespace App\Models;

use App\Database;

class ProductModel extends Model {

  private $product = ['azerty' => '123456'];

  public function __construct(Database $db) {
    parent::__construct($db);

  }

  public function importData() {
    $file = array_slice(file(ROOT . '/extra/products-data.tsv', FILE_SKIP_EMPTY_LINES), 1);
    dump($file);
  }

}
