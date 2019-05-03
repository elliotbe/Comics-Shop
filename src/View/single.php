<div class="container product__container">
  <div class="product__thumbnail">
    <img src="<?= $product->img_src ?>" alt="thumbnail image">
    <div><?= $product->ref ?></div>
    <div><?= $product->price ?>€</div>
    <div>
      <a href="<?= generateUrl('Product#single', [
        'id'   => $product->product_id,
        'slug' => $product->slug
      ]) ?>"><?= $product->title ?></a>
    </div>
    <div><?= $product->category ?></div>
    <div><?= $product->synopsis ?></div>
    <div><?= dump($product) ?></div>
  </div>
</div>
