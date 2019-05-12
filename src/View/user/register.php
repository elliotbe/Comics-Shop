<div class="container form__container">
  <?php require(__DIR__ . '/../partial/flash-message.php') ?>

  <h2 class="form__title">Inscription</h2>
  <form class="form" action="" method="POST">

    <?php require(__DIR__ . '/../partial/error-message.php') ?>

    <?= $form->input('email', null, [
      'type' => 'email',
      'placeholder' => 'mrrobot@fsociety.com',
      'autocomplete' => 'username-email',
      'required',
    ]) ?>

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
      <input class="btn btn-secondary" type="submit" value="S'inscrire">
    </div>

  </form>
</div>
