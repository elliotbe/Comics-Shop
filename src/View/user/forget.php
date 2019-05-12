<div class="container form__container">
  <?php require(ROOT . 'src/View/partial/flash-message.php') ?>

  <h2 class="form__title">Mot de passe oublié</h2>
  <form class="form" action="" method="POST">

    <?php require(ROOT . 'src/View/partial/error-message.php') ?>

    <?= $form->input('email', null, [
      'type' => 'email',
      'placeholder' => 'mrrobot@fsociety.com',
      'autocomplete' => 'username-email',
      'required',
    ]) ?>



    <div class="form__btn-wrap">
      <a class="btn btn-primary" href="<?= lastPageUrl() ?>">Retour</a>
      <input class="btn btn-secondary" type="submit" value="Réinitialiser">
    </div>

  </form>
</div>
