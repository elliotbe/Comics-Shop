<div class="container form__container">
  <?php require(ROOT . 'src/View/partial/flash-message.php') ?>



  <h2 class="form__title">Vos dernières commandes</h2>
<br>
<br>
<br>

  <h2 class="form__title">Modifier vos informations</h2>
  <form class="form" action="" method="POST">

    <?php require(ROOT . 'src/View/partial/error-message.php') ?>

    <?= $form->input('email', null, [
      // 'type' => 'email',
      'placeholder' => 'mrrobot@fsociety.com',
      'autocomplete' => 'username-email',
      'required',
    ]) ?>

    <?= $form->input('first_name', 'Prénom', [

    ]) ?>

    <?= $form->input('last_name', 'Nom', [

    ]) ?>

    <?= $form->input('address', 'Addresse', [

    ]) ?>

    <?= $form->input('city', 'Ville', [

    ]) ?>

    <?= $form->input('zip_code', 'Code Postal', [

    ]) ?>



    <div class="form__btn-wrap">
        <input class="btn btn-secondary" type="submit" value="Modifier">
    </div>


  </form>

  <h2 class="form__title">Changer votre mot de passe</h2>
  <form class="form" action="/changer-de-mot-de-passe?id=<?= $user_id ?>" method="POST">

    <?= $form->input('old_password', 'Ancien mot de passe', [
      'required'
    ]) ?>

    <?= $form->input('new_password', 'Nouveau mot de passe', [
      'required'
    ]) ?>

    <?= $form->input('new_password_confirm', 'Confirmer le mot de passe', [
      'required'
    ]) ?>

    <div class="form__btn-wrap">
        <input class="btn btn-primary" type="submit" value="Réinitialiser">
    </div>

  </form>

  <h2 class="form__title">Supprimer votre compte</h2>
  <form class="form" action="/supprimer-le-compte?id=<?= $user_id ?>" method="POST">
      <legend>Merci de confirmer votre mot de passe pour supprimer votre compte</legend>

    <?= $form->input('password', 'Mot de passe', [
      'required',
    ]) ?>

    <div class="form__btn-wrap">
        <input class="btn btn-secondary" type="submit" value="Êtes vous sûr ?">
    </div>

  </form>

</div>
