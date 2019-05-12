<hgroup>
  <h2>Afin de valider votre compte</h2>
  <h3>Merci de cliquer sur
    <a href="<?= "{$_SERVER['HTTP_HOST']}/confirmation?id=$user_id&token=$token" ?>">
      ce lien
    </a>
  </h3>
</hgroup>
<?php require(__DIR__ .  '/style.html') ?>
