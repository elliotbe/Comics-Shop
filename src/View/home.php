<div class="container product__container">
  <h2>Home</h2>

  <?php foreach ($products as $product): ?>
  <div><?= $product->ref ?></div>
  <div><?= $product->price ?>€</div>
  <div>
    <a href="<?= generateUrl('Product#single', [ 'id' => strtolower($product->id), 'slug' => $product->slug ]) ?>">
      <?= $product->title ?>
    </a>
  </div>
  <div><?= $product->category ?></div>
  <div><?= $product->synopsis ?></div>
  <div><?= dump($product) ?></div>
  <?php endforeach ?>
</div>
