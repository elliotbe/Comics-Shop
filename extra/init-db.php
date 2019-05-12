<?php
declare(strict_types = 1);
require 'vendor/autoload.php';

use App\Database\DatabaseSchema;

$db_host = App::config()->get('DB_HOST');
$db_name = App::config()->get('DB_NAME');
$db_user = App::config()->get('DB_USER');
$db_pass = App::config()->get('DB_PASS');
$db = new DatabaseSchema($db_host, null, $db_user, $db_pass);

$db->query("DROP DATABASE `$db_name`");

$db_exists = !(bool)$db->createDatabase($db_name)->rowCount();
if ($db_exists) {
  printLine("The database $db_name already exist.");
  printLine("You should delete it and reload this script if you want to reinitialize it.\n");
  return;
}
printLine("The database '$db_name' doesn't exist and will be created");

$db = new DatabaseSchema($db_host, $db_name, $db_user, $db_pass);

$db->addTable('product', [
  $db->addColumn('product_id', 'INT', '8', 'UNSIGNED AUTO_INCREMENT PRIMARY KEY'),
  $db->addColumn('ref', 'VARCHAR', '8', 'NOT NULL UNIQUE'),
  $db->addColumn('title', 'VARCHAR', '120', 'NOT NULL UNIQUE'),
  $db->addColumn('price_supplier', 'DECIMAL', '8,2', 'UNSIGNED'),
  $db->addColumn('price', 'DECIMAL', '8,2', 'UNSIGNED'),
  $db->addColumn('author_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('category_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('hero_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('editor_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('supplier_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('ref_editor', 'VARCHAR', '24', 'UNIQUE'),
  $db->addColumn('ref_supplier', 'VARCHAR', '24', 'UNIQUE'),
  $db->addColumn('synopsis', 'TEXT'),
]);
printLine("Create table 'product'");

$tables_name = ['author', 'category', 'hero', 'editor', 'supplier'];
foreach ($tables_name as $table_name) {
  $db->addTable($table_name, [
    $db->addColumn("{$table_name}_id", 'INT', '8', 'UNSIGNED AUTO_INCREMENT PRIMARY KEY'),
    $db->addColumn('content', 'VARCHAR', '120', 'NOT NULL'),
  ]);
  printLine("Create table '$table_name'");
}

foreach ($tables_name as $key_name) {
  $db->addForeignKey($key_name, 'product', 'SET NULL', 'CASCADE');
  printLine("Foreign key added to 'product.{$key_name}_id'");
}

$db->query(
  "CREATE VIEW IF NOT EXISTS product_view AS SELECT
    product.product_id, product.ref, product.title,
    product.price_supplier, product.price,
    product.author_id, author.content AS author,
    product.category_id, category.content AS category,
    product.hero_id, hero.content AS hero,
    product.editor_id, editor.content AS editor,
    product.supplier_id, supplier.content AS supplier,
    product.ref_editor, product.ref_supplier, product.synopsis
  FROM product
  LEFT JOIN author   ON product.author_id = author.author_id
  LEFT JOIN hero     ON product.hero_id = hero.hero_id
  LEFT JOIN category ON product.category_id = category.category_id
  LEFT JOIN editor   ON product.editor_id = editor.editor_id
  LEFT JOIN supplier ON product.supplier_id = supplier.supplier_id
");
printLine("Create view 'product_view'");

$products_list = array_slice(file('extra/comics-shop-data.tsv'), 1);
$product_model = App::getModel('product');

foreach ($products_list as $product_line) {
  $product_line = explode("\t", $product_line);

  foreach ($product_line as &$product_field) {
    $product_field = str_replace("\r\n", '', $product_field);
    empty($product_field) ? $product_field = null : null;
  }

  $product_line = array_combine([
    'ref', 'title', 'price_supplier', 'price', 'author', 'category',
    'hero', 'editor', 'supplier', 'ref_editor', 'ref_supplier', 'synopsis'
  ], $product_line);

  foreach ($tables_name as $field_name) {
    if ($product_line[$field_name]) {
      $product_line[$field_name] = capitalize($product_line[$field_name]);
    }
  }

  $product_model->insert($product_line);
}

$row_count = $db->query("SELECT COUNT(*) FROM product_view")->fetchColumn();
printLine("Inserted $row_count new product into the database\n");

$db->addTable('user', [
  $db->addColumn('user_id', 'INT', '8', 'UNSIGNED AUTO_INCREMENT PRIMARY KEY'),
  $db->addColumn('email', 'VARCHAR', '120', 'NOT NULL UNIQUE'),
  $db->addColumn('password', 'VARCHAR', '255', 'NOT NULL UNIQUE'),
  $db->addColumn('first_name', 'VARCHAR', '60'),
  $db->addColumn('last_name', 'VARCHAR', '60'),
  $db->addColumn('address', 'VARCHAR', '255'),
  $db->addColumn('zip_code', 'VARCHAR', '20'),
  $db->addColumn('city', 'VARCHAR', '60'),
  $db->addColumn('registred_at', 'DATETIME'),
  $db->addColumn('registration_token', 'VARCHAR', '60'),
  $db->addColumn('reseted_at', 'DATETIME'),
  $db->addColumn('reset_token', 'VARCHAR', '60'),
  $db->addColumn('remember_token', 'VARCHAR', '60'),
  $db->addColumn('privilege', 'VARCHAR', '60', "NOT NULL DEFAULT 'user'"),
]);
printLine("Create table 'user'");

$user_model = App::getModel('User')->upsert([
  'email' => 'elbelet@gmail.com',
  'password' => \App::auth()->hashPassword('azerty'),
  'privilege' => 'admin',
  'registration_token' => null,
  'registred_at' => date("Y-m-d H:i:s")
]);
$user_model = App::getModel('User')->upsert([
  'email' => 'sergentgarcia@yahoo.it',
  'password' => \App::auth()->hashPassword('azerty'),
  'registration_token' => null,
  'registred_at' => date("Y-m-d H:i:s")
]);
$user_model = App::getModel('User')->upsert([
  'email' => 'pierpoljak@libertysurf.fr',
  'password' => \App::auth()->hashPassword('azerty'),
  'registration_token' => null,
  'registred_at' => date("Y-m-d H:i:s")
]);
$user_model = App::getModel('User')->upsert([
  'email' => 'mrrobot@fucksociety.com',
  'password' => \App::auth()->hashPassword('azerty'),
  'registration_token' => generateToken(60)
]);

$db->addTable('message', [
  $db->addColumn('message_id', 'INT', '8', 'UNSIGNED AUTO_INCREMENT PRIMARY KEY'),
  $db->addColumn('user_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('email', 'VARCHAR', '120'),
  $db->addColumn('content', 'TEXT'),
  $db->addColumn('date', 'DATETIME', null, 'DEFAULT CURRENT_TIMESTAMP')
]);
printLine("Create table 'message'");
$db->addForeignKey('user', 'message');

$db->addTable('order', [
  $db->addColumn('order_id', 'INT', '8', 'UNSIGNED AUTO_INCREMENT PRIMARY KEY'),
  $db->addColumn('user_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('order_number', 'INT', '8', 'UNSIGNED ZEROFILL'),
  $db->addColumn('date', 'DATETIME', null, 'DEFAULT CURRENT_TIMESTAMP'),
  $db->addColumn('total_amount', 'DECIMAL', '8,2', 'UNSIGNED'),
  $db->addColumn('status', 'VARCHAR', '20', "NOT NULL DEFAULT 'ordered'")
]);
printLine("Create table 'order'");
$db->addForeignKey('user', 'order');

$db->addTable('basket', [
  $db->addColumn('user_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('product_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('quantity', 'INT', '4', 'UNSIGNED NOT NULL'),
]);
printLine("Create table 'basket'");
$db->query('ALTER TABLE basket ADD PRIMARY KEY product_basket_id (user_id, product_id)');
$db->addForeignKey('product', 'basket', 'CASCADE', 'CASCADE');
$db->addForeignKey('user', 'basket', 'CASCADE', 'CASCADE');

$db->addTable('order_item', [
  $db->addColumn('order_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('product_id', 'INT', '8', 'UNSIGNED'),
  $db->addColumn('quantity', 'INT', '4', 'UNSIGNED NOT NULL'),
]);
printLine("Create table 'order_item'");
$db->query('ALTER TABLE order_item ADD PRIMARY KEY product_order_id (order_id, product_id)');
$db->addForeignKey('order', 'order_item');
$db->addForeignKey('product', 'order_item');
