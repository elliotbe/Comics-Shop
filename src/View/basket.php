<div class="container basket__container">
  <?php if(getBasketCount() === 0): ?>
    <div class="basket__empty-wrap">
      <hgroup class="basket__title">
        <h2>Vous n'avez rien</h2>
        <h3>ajouté à votre panier pour le moment</h3>
      </hgroup>
      <a href="<?= lastPageUrl() ?>" class="btn btn-primary basket__btn-back--single">Retour</a>
    </div>
  <?php else: ?>
    <?php foreach($basket_data as $product): ?>
      <div class="basket-item">
        <div class="basket-item__img-wrap">
          <img class="basket-item__img" src="<?= $product->img_src ?>" alt="product cover">
          <div class="basket-item__price"><?= $product->parsed_price ?></div>
        </div>
        <div class="basket-item__col-2">
          <h3 class="basket-item__title"><?= $product->title ?></h3>
          <?= $product->fieldNotNull('author', 'div', false) ?>
          <?= $product->fieldNotNull('category', 'div', false) ?>
          <?= $product->fieldNotNull('hero', 'div', false) ?>
          <?= $product->fieldNotNull('editor', 'div', false) ?>
        </div>
        <div class="basket-item__col-3">
          <div class="basket-item__btn-wrap">
            <a class="btn basket-item__btn-less" href="/mon-panier/retirer-<?= $product->product_id ?>">-</a>
            <a class="btn basket-item__btn-delete" href="/mon-panier/supprimer-<?= $product->product_id ?>">Supprimer</a>
            <a class="btn basket-item__btn-more" href="/mon-panier/ajouter-<?= $product->product_id ?>">+</a>
          </div>
          <div>Quantité : <strong class="strong"><?= $product->quantity ?></strong></div>
          <div>Total : <strong class="strong"><?= parseFloat($product->quantity * $product->price) ?>€</strong></div>
        </div>

      </div>
    <?php endforeach ?>
    <div class="basket__footer">
      <div class="basket__total-price">Total : <strong class="strong"><?= $total_price ?></strong></div>
      <a href="<?= lastPageUrl() ?>" class="btn btn-primary">Retour</a>
      <a href="/confirmation" class="btn btn-secondary">Confirmer la commande</a>
    </div>
  <?php endif ?>
</div>
