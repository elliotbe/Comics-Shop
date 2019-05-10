<div class="container">
  <?php require('partial/flash-message.php') ?>
</div>

<div class="container thumbnail__container">

  <?php if (isset($main_title)): ?>
    <h2 class="page-title"><?= $main_title ?></h2>
  <?php endif ?>

  <?= $pager->generate() ?>

  <div class="modal__wrap">
    <div class="modal modal-hide"></div>
    <div class="modal__cover modal__cover-hide" onclick="closeModal()"></div>
  </div>

  <div class="thumbnail__grid">

    <?php foreach ($products as $product): ?>
      <div class="thumbnail">
        <div class="thumbnail__img-wrap">
          <img class="thumbnail__img" src="<?= $product->img_src ?>" alt="thumbnail image">
          <div class="thumbnail__price"><?= $product->parsed_price ?></div>
        </div>
        <h3 class="<?= $product->title_class_name ?>"><?= $product->title ?></h3>
        <div class="thumbnail__btn-wrap">
          <button class="btn btn-primary" onclick="openModal('<?= $product->modal_url ?>')">Détails</button>
          <a
            href="/mon-panier/ajouter-<?= $product->product_id ?>"
            class="btn btn-secondary"
            <?= $product->order_is_disabled ?>
          >Acheter</a>
        </div>
      </div>
    <?php endforeach ?>

  </div>

  <?= $pager->generate() ?>

</div>
