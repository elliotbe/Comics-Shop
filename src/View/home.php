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
          <h4>
            <a href="<?= generateUrl('Product#single', [
              'id' => $product->product_id,
              'slug' => $product->slug
            ]) ?>"><?= $product->title ?></a>
          </h4>
        </div>
        <div><?= $product->category ?></div>
        <div><?= $product->synopsis ?></div>
        <div><?= dump($product) ?></div>
      </div>
    <?php endforeach ?>
  </div>
</div>
