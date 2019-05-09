<div class="container">
  <?php foreach ($flash_message as $type => $message) : ?>
    <div class="flash-msg flash-msg__<?= $type ?>">
      <?= $message ?>
      <button class="flash-msg__close-btn" onclick="closeFlashMsg(this)"></button>
    </div>
  <?php endforeach ?>
</div>
