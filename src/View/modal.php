<div class="modal__grid">
  <div class="modal__img-wrap">
    <img class="modal__img" src="<?= $product->img_src ?>" alt="product cover">
    <div class="modal__price"><?= $product->parsed_price ?></div>
  </div>
  <div class="modal__data-wrap">
    <h3 class="modal__title"><?= $product->title ?></h3>
    <?= $product->fieldNotNull('author') ?>
    <?= $product->fieldNotNull('category') ?>
    <?= $product->fieldNotNull('hero') ?>
    <?= $product->fieldNotNull('editor') ?>
  </div>
  <div class="modal__synopsis"><?= $product->synopsis ?></div>
  <div class="modal__btn-wrap">
    <button onclick="closeModal()" class="btn btn-primary">Retour</button>
    <a
      href="/mon-panier/ajouter-<?= $product->product_id ?>"
      class="btn btn-secondary"
      <?= $product->order_is_disabled ?>
    >Acheter</a>
  </div>
</div>
