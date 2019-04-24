<?php
declare(strict_types = 1);
require 'vendor/autoload.php';

use App\Database\DatabaseSchema;


$db_host = App::config()->get('DB_HOST');
$db_name = App::config()->get('DB_NAME');
$db_user = App::config()->get('DB_USER');
$db_pass = App::config()->get('DB_PASS');
$db_schema = new DatabaseSchema($db_host, null, $db_user, $db_pass);

$db_schema->query("DROP DATABASE `$db_name`");
$db_exists = !(bool)$db_schema->createDatabase($db_name)->rowCount();
if ($db_exists) {
  printLine("The database $db_name already exist.");
  printLine("You should delete it and reload this script if you want to reinitialize it.\n");
  return;
}
printLine("The database '$db_name' doesn't exist and will be created");

$db_schema = new DatabaseSchema($db_host, $db_name, $db_user, $db_pass);

$db_schema->createTable('product', [
  $db_schema->addColumn('ref', 'VARCHAR', '8', 'NOT NULL PRIMARY KEY'),
  $db_schema->addColumn('title', 'VARCHAR', '255', 'NOT NULL UNIQUE'),
  $db_schema->addColumn('price_supplier', 'DOUBLE', '6,2', 'UNSIGNED'),
  $db_schema->addColumn('price', 'DOUBLE', '6,2', 'UNSIGNED'),
  $db_schema->addColumn('author_id', 'INT'),
  $db_schema->addColumn('category_id', 'INT'),
  $db_schema->addColumn('hero_id', 'INT'),
  $db_schema->addColumn('editor_id', 'INT'),
  $db_schema->addColumn('supplier_id', 'INT'),
  $db_schema->addColumn('ref_editor', 'VARCHAR', '24', 'UNIQUE'),
  $db_schema->addColumn('ref_supplier', 'VARCHAR', '24', 'UNIQUE'),
  $db_schema->addColumn('synopsis', 'TEXT'),
]);
printLine("Create table 'product'");

$tables_name = ['author', 'category', 'hero', 'editor', 'supplier'];
foreach ($tables_name as $table_name) {
  $db_schema->createTable($table_name, [
    $db_schema->addColumn('id', 'INT', null, 'NOT NULL AUTO_INCREMENT PRIMARY KEY'),
    $db_schema->addColumn('content', 'VARCHAR', '255', 'NOT NULL UNIQUE'),
  ]);
  printLine("Create table '$table_name'");
  $db_schema->addForeignKey($table_name, 'product', 'SET NULL', 'CASCADE');
}
foreach ($tables_name as $key_name) {
  $db_schema->addForeignKey($key_name, 'product', 'SET NULL', 'CASCADE');
  printLine("Foreign key added to 'product.{$key_name}_id'");
}

$db_schema->query(
  "CREATE VIEW IF NOT EXISTS product_view AS SELECT
    product.ref, product.title, product.price_supplier, product.price,
    product.author_id, author.content AS author,
    product.category_id, category.content AS category,
    product.hero_id, hero.content AS hero,
    product.editor_id, editor.content AS editor,
    product.supplier_id, supplier.content AS supplier,
    product.ref_editor, product.ref_supplier, product.synopsis
  FROM product
  LEFT JOIN author   ON author_id   = author.id
  LEFT JOIN hero     ON hero_id     = hero.id
  LEFT JOIN category ON category_id = category.id
  LEFT JOIN editor   ON editor_id   = editor.id
  LEFT JOIN supplier ON supplier_id = supplier.id
");
echo "Create view 'product_view'\n";

$products_list = array_slice(file('extra/products-data.tsv'), 1);
$product_model = App::getModel('product');

foreach ($products_list as $product) {
  $product_data = explode("\t", $product);
  foreach ($product_data as &$product_field) {
    $product_field = str_replace("\r\n", '', $product_field);
    empty($product_field) ? $product_field = null : $product_field;
  }
  $product_data = [
    'ref'            => $product_data[0],
    'title'          => $product_data[1],
    'price_supplier' => $product_data[2],
    'price'          => $product_data[3],
    'author'         => $product_data[4],
    'category'       => $product_data[5],
    'hero'           => $product_data[6],
    'editor'         => $product_data[7],
    'supplier'       => $product_data[8],
    'ref_editor'     => $product_data[9] ?? null,
    'ref_supplier'   => $product_data[10] ?? null,
    'synopsis'       => $product_data[11] ?? null,
  ];
  $product_model->insert($product_data);
}

$row_count = $db_schema->query("SELECT * FROM product_view")->rowCount();
printLine("Inserted $row_count new product into the database\n");
