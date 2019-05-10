<?php if (!empty($errors)): ?>
  <div class="msg-error">
    <ul class="msg-error__list">
      <?php foreach ($errors as $error_msg): ?>
        <li class="msg-error__list-item"><?= $error_msg ?></li>
      <?php endforeach ?>
    </ul>
  </div>
<?php endif ?>
