<div class="container form__container">
  <?php require(__DIR__ . '/../partial/flash-message.php') ?>

  <h2 class="form__title">Connexion</h2>
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
      'autocomplete' => 'current-password',
      'minlength' => '4'
    ]) ?>

    <div class="form__footer">
      <div class="form__checkbox-wrap">
        <?= $form->checkbox('remember', 'Se rappeler de moi') ?>
      </div>

      <div class="form__footer-text">
        Pas encore inscrit ? <a class="form__link" href="/inscription">Inscription</a>
        <br>
        Mot de passe oubliée ? <a class="form__link" href="/reset">Réinitialiser</a>
      </div>

      <div class="form__btn-wrap">
        <a class="btn btn-primary" href="<?= lastPageUrl() ?>">Retour</a>
        <input class="btn btn-secondary" type="submit" value="Se connecter">
      </div>
    </div>

  </form>
</div>
