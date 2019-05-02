<div class="container error__container">
  <hgroup class="error__title">
    <h2>Ooups!</h2>
    <h3>Une erreur s'est produite.</h3>
  </hgroup>
  <video
  class="error__gif" src=<?= getRandomGif() ?> type="video/mp4"
  autoplay loop muted playsinline
  ></video>
  <p class="error__text"><?= $error_msg ?></p>
</div>
