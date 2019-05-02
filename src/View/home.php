<div class="container product__container">
  <?php if (isset($main_title)): ?>
    <h2><?= $main_title ?></h2>
  <?php endif ?>

  <div class="product__grid">
    <?php foreach ($products as $product): ?>
      <div class="product__thumbnail">
        <img src="<?= $product->img_src ?>" alt="thumbnail image">
        <div><?= $product->ref ?></div>
        <div><?= $product->price ?>€</div>
        <div>
          <a href="<?= generateUrl('Product#single', [
            'id' => strtolower($product->id),
            'slug' => $product->slug
          ]) ?>"><?= $product->title ?></a>
        </div>
        <div><?= $product->category ?></div>
        <div><?= $product->synopsis ?></div>
        <div><?= dump($product) ?></div>
      </div>
    <?php endforeach ?>
  </div>
</div>
