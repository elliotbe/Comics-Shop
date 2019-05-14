<div class="container">
  <?php require(ROOT . 'src/View/partial/error-message.php') ?>
</div>

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
    <h2 class="form__title">Récapitulatif de votre commande</h2>
    <?php foreach($basket_data as $product): ?>
      <div class="basket-item">
        <h3 class="basket-item__title"><?= $product->title ?></h3>
        <div>Quantité : <strong class="strong"><?= $product->quantity ?></strong></div>
        <div>Total : <strong class="strong"><?= parseFloat($product->quantity * $product->price) ?>€</strong></div>
      </div>
    <?php endforeach ?>
    <div class="basket__footer">
      <div class="basket__total-price">Total : <strong class="strong"><?= $total_price ?></strong></div>
    </div>
  <?php endif ?>


  <h2 class="form__title">Entrer votre addresse</h2>
  <form class="form" action="/payer-ma-commande" method="POST">

    <?php require(ROOT . 'src/View/partial/error-message.php') ?>

    <?= $form->input('first_name', 'Prénom', [
      'required',
    ]) ?>

    <?= $form->input('last_name', 'Nom', [
      'required',
    ]) ?>

    <?= $form->input('address', 'Addresse', [
      'required',
    ]) ?>

    <?= $form->input('city', 'Ville', [
      'required',
    ]) ?>

    <?= $form->input('zip_code', 'Code Postal', [
      'required',
    ]) ?>


    <div class="form__btn-wrap">
      <a href="/mon-panier" class="btn btn-primary">Retour</a>
      <input class="btn btn-secondary" type="submit" value="Payer ma commande">
    </div>


  </form>


</div>
