<div class="container form__container">
  <?php require(ROOT . 'src/View/partial/flash-message.php') ?>

  <h2 class="form__title">Réinitialiser votre mot de passe</h2>
  <form class="form" action="" method="POST">

    <?php require(ROOT . 'src/View/partial/error-message.php') ?>

    <?= $form->input('password', 'Mot de passe', [
      'type' => 'password',
      'placeholder' => '●●●●●●',
      'required',
      'autocomplete' => 'new-password',
      'minlength' => '4'
    ]) ?>

    <?= $form->input('password_confirm', 'Confirmer le mot de passe', [
      'type' => 'password',
      'placeholder' => '●●●●●●',
      'required',
      'autocomplete' => 'new-password',
      'minlength' => '4'
    ]) ?>



    <div class="form__btn-wrap">
      <a class="btn btn-primary" href="<?= lastPageUrl() ?>">Retour</a>
      <input class="btn btn-secondary" type="submit" value="Réinitialiser">
    </div>

  </form>
</div>
