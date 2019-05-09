<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= setPageName($page_name) ?></title>
  <link rel="stylesheet" href="/css/style.css">
  <script defer src="/js/main.js"></script>
</head>
<body class="preload">

  <header class="header">
    <div class="container header__container">
      <div class="header__wrap-link">
        <a class="header__link active-link" href="/user/login">Se connecter</a>
        <a class="header__link active-link" href="/mon-panier">Panier<br><?= getBasketCount() ?> Items</a>
      </div>

      <h1 class="logo-site">
        <a href="/">
          <span>Comics Shop</span>
          <svg version="1.1" class="logo-site__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 190 48" xml:space="preserve"> <g class="logo-site__svg__main"> <path d="M91.6,20.7c1.9,0,3.4-0.6,4.6-1.7c1.2-1.1,1.9-2.5,1.9-4c0-1.5-0.5-2.7-1.5-3.6c-1-0.8-2.4-1.3-4.3-1.3		c-1.8,0-3.4,0.5-4.7,1.5c-1.3,1-1.9,2.3-1.9,3.8c0,1.5,0.5,2.8,1.6,3.7C88.3,20.2,89.7,20.7,91.6,20.7z"/> <path d="M136.4,28.9c0.1-1.6-0.4-2.8-1.6-3.7c-1.2-0.9-2.8-1.4-4.9-1.6c-3.4-0.3-6,0.4-7.8,2.1c-1.1,0.9-1.7,2.2-1.8,3.7		c-0.1,1.6,0.6,3.4,2.1,5.6c0.6,0.9,1.3,1.9,2.1,3c0.2,0.2,0.4,0.6,0.7,1c0.3,0.5,0.5,0.8,0.6,1.1c0.1,0.3,0.3,0.6,0.5,1		c0.2,0.4,0.3,0.9,0.3,1.4c0,0.7-0.6,0.9-1.6,0.9c-1.1-3-2.3-5.1-3.9-6c-1,0.1-2,0.7-3.1,1.6l0.2-0.2c-1.9,1.6-5.3,2.8-6.8,2.9		c-2.5,0.1-3.8-1.9-4-6.2c-0.1-1.9,0.2-3.9,0.9-5.8c0.7-1.9,1.5-2.9,2.6-3c0.2,0,0.4,0,0.6,0.1l-0.6,3.9c0.8,0.6,1.9,1.1,3.3,1.5		c1.4,0.4,2.6,0.5,3.7,0.5c0.9-1.2,1.3-2.6,1.2-4.2c-0.1-1.6-0.9-2.9-2.4-3.9c-1.5-1-3.6-1.4-6.2-1.3c-4,0.2-7.2,1.6-9.5,4.3		c-2.3,2.7-3.4,6-3.2,10c0.1,1.3,0.2,2.4,0.5,3.4L98.2,41c-1,0.3-1.7,0.5-2.1,0.5c-0.4,0-0.6-0.5-0.6-1.4c0-1,0.4-3,1.3-6.2		c0.9-3.2,1.3-5.5,1.3-7.1c0-1.5-0.3-2.6-0.8-3.2c-5.2,0-8.7,0.3-10.5,0.8l-0.2,0.9l0.4,0.6c0.9,1.1,1.3,2.3,1.3,3.6		c0,0.8-0.4,2.8-1.3,5.9c-0.6,2.3-1,4.2-1.2,5.7l-2.5,0.6c-0.3,0-0.4-0.4-0.4-1.3c0-0.8,0.4-2.7,1.1-5.7c0.8-3,1.1-5.1,1.1-6.4		s-0.4-2.5-1.3-3.4c-0.9-0.9-2.1-1.4-3.7-1.4c-2.4,0-5,1.1-7.9,3.2c-0.3-1-0.9-1.7-1.6-2.3c-0.8-0.6-1.7-0.9-2.8-0.9		c-2.1,0-4.6,1-7.6,2.9c-0.1-0.9-0.4-1.7-0.8-2.5c-5.1,0-8.6,0.3-10.6,1l-0.1,0.8l0.5,0.5c0.3,0.3,0.6,0.8,0.9,1.3		c0.3,0.6,0.5,1.1,0.5,1.6c0,0.1,0,0.1,0,0.3L50,29.4c-1.3,0.4-2.7,0.6-4.2,0.7c-0.1-2.2-0.5-3.8-1.3-5c-0.7-1.2-2-1.8-3.7-1.8		c-0.7,0-1.5,0.1-2.3,0.4l-2.3-0.2c-3.7,0-6.6,1.3-8.9,4s-3.4,5.8-3.4,9.6c0,0.1,0,0.2,0,0.3c-2.9,2.5-5.5,3.8-7.8,3.8		c-3.9,0-5.9-3.5-5.9-10.4c0-4.6,0.8-8.7,2.3-12.2c1.5-3.5,3.3-5.2,5.3-5.2c0.7,0,1.4,0.2,2.1,0.5l-1,5c0.9,0.8,2.3,1.5,4.1,2		c1.8,0.6,3.4,0.8,4.8,0.8c1.2-1.2,1.8-2.9,1.8-5c0-2.1-1.1-3.8-3.2-5.1c-2.2-1.3-4.9-2-8.2-2c-3.3,0-6.4,1-9.2,3.1		c-2.9,2-5,4.7-6.5,8.1C0.8,24,0,27.6,0,31.5c0,4.9,1.2,8.6,3.5,11.3c2.3,2.7,5.4,4,9.1,4c1.6,0,3.1-0.3,4.6-0.8		c1.5-0.5,2.8-1.1,3.8-1.7c1-0.6,2.1-1.4,3.2-2.5c0.1-0.1,0.2-0.2,0.3-0.3c0.4,1,0.9,1.9,1.6,2.7c1.6,1.7,3.7,2.6,6.4,2.6		c3.4,0,6.2-1.3,8.4-3.8c2.3-2.5,3.8-5.6,4.5-9.2c1.7-0.3,3.2-0.8,4.5-1.3c-0.2,1-0.5,2.3-0.8,3.8c-1,4.4-1.4,7.8-1.4,10.3h1.3		c3.8,0,6.5-0.3,8.2-0.9c0-2.3,0.6-6,1.8-11.1c0.6-2.4,0.9-3.9,1-4.5c0.9-0.6,1.7-0.8,2.3-0.8c0.5,0,0.7,0.3,0.7,0.8		c0,0.6-0.4,2.6-1.1,6.2c-0.8,3.6-1.1,6.1-1.1,7.5c0,1.4,0.1,2.3,0.2,2.7c4.6,0,7.7-0.3,9.3-0.9c0-3.4,0.5-7.3,1.5-11.7		c0.4-2,0.7-3.2,0.8-3.7c0.8-0.6,1.6-0.9,2.3-0.9c0.5,0,0.8,0.3,0.8,1c0,0.7-0.4,2.5-1.1,5.6c-0.7,3.1-1.1,5.2-1.1,6.5		c0,3,1.5,4.5,4.5,4.5c1.5,0,3.1-0.3,4.9-1c1.3-0.5,2.4-1,3.4-1.6c0.2,0.6,0.5,1.1,0.9,1.5c0.8,0.8,1.9,1.2,3.4,1.2		c1.4,0,3-0.3,4.8-1c1.7-0.7,3.2-1.5,4.4-2.4l0-0.1c0.4,0.5,0.8,1,1.2,1.5c1.8,1.6,4,2.3,6.7,2.1c2-0.1,4-0.6,6-1.6		c1.1-0.5,2.1-1.2,3-2c0.4,0.5,1,1,1.9,1.6c1.6,1,3.8,1.6,6.5,1.8c2.7,0.2,5-0.4,7.1-1.7c2.1-1.3,3.2-3,3.4-5.2		c0.1-1.7-0.6-3.6-2.2-5.8C135.2,32.2,136.3,30.5,136.4,28.9z M39.6,39.5c-1.2,1.4-2.4,2.2-3.5,2.2c-1.6,0-2.4-1.6-2.4-4.8		c0-1.9,0.3-3.7,0.8-5.6c0.5-1.9,1.1-3.1,1.7-3.7c0.2-0.1,0.4-0.2,0.8-0.2c-0.1,0.6-0.2,1.2-0.2,1.8c0,3.4,1.8,5.1,5.3,5.1		C41.6,36.3,40.8,38,39.6,39.5z M131.2,31.6c-1.4-1.8-2-2.9-2-3.4c0-0.5,0.2-0.9,0.6-1.1c0.4-0.3,0.8-0.4,1.5-0.3		c0.6,0,1.1,0.2,1.6,0.5c0.4,0.3,0.6,0.7,0.6,1.2c0,0.5-0.3,1.1-0.8,1.7C132.2,30.8,131.7,31.3,131.2,31.6z"/> </g> <g class="logo-site__svg__bubble"> <path d="M183.6,9.2C179.1,3.7,171.4,0,162.7,0c-13.9,0-25.2,9.3-25.2,20.8c0,5.2,2.4,10.1,6.6,13.9c0.6,0.5,1.2,1,1.8,1.5l-0.1,0.3		l-3.9,7.8c-0.2,0.4-0.1,0.9,0.2,1.3c0.2,0.2,0.4,0.3,0.7,0.3c0.2,0,0.4-0.1,0.6-0.2l1.5-1l-0.9,1.9c-0.2,0.4-0.1,0.9,0.2,1.3		c0.2,0.2,0.4,0.3,0.7,0.3c0.2,0,0.4-0.1,0.6-0.2l8.9-5.9c3.3,1.3,6.9,1.9,10.5,1.9c13.9,0,25.2-9.3,25.2-20.8		C190,17.7,187.6,12.9,183.6,9.2z M162.7,39.5c-3.6,0-7-0.7-10.2-2c-0.3-0.1-0.7-0.1-1,0.1l-4.7,3.1l-1.3,0.9l1.9-3.7l0.8-1.6		c0.2-0.5,0.1-1-0.3-1.3c-4.9-3.4-7.8-8.1-8.1-13.2c0-0.3-0.1-0.7-0.1-1c0-10.3,10.4-18.7,23.1-18.7c0.9,0,1.8,0.1,2.7,0.1		c11.4,1.1,20.4,9,20.4,18.6C185.8,31.1,175.4,39.5,162.7,39.5z"/> <path d="M150.9,14.1c-0.5-0.2-1-0.2-1.6-0.2c-0.7,0-1.4,0.2-2,0.5c-0.6,0.3-1,0.9-1.3,1.5c-0.3,0.7-0.5,1.4-0.5,2.3		c0,0.9,0.1,1.6,0.4,2.2c0.3,0.6,0.8,1.1,1.5,1.6c0.4,0.3,0.7,0.5,0.9,0.7c0.2,0.2,0.2,0.5,0.2,0.8c0,0.7-0.3,1-1,1		c-0.8,0-1.7-0.4-2.5-1.3l-0.5,3.2c0.4,0.3,0.8,0.5,1.3,0.7c0.5,0.2,1,0.3,1.6,0.3c0.8,0,1.5-0.2,2.1-0.5s1-0.8,1.4-1.5		c0.3-0.7,0.5-1.4,0.5-2.3c0-0.9-0.1-1.6-0.4-2.2c-0.3-0.6-0.8-1.1-1.5-1.7c-0.5-0.4-0.7-0.6-0.9-0.8c-0.1-0.2-0.2-0.4-0.2-0.7		c0-0.3,0.1-0.5,0.3-0.7c0.2-0.2,0.4-0.3,0.7-0.3c0.4,0,0.7,0.1,1.1,0.2c0.4,0.1,0.8,0.4,1.2,0.8l0.5-3.1		C151.8,14.4,151.4,14.2,150.9,14.1z"/> <polygon points="159.3,18.9 156.2,18.9 156.9,14.1 154.1,14.1 152.2,27.1 154.9,27.1 155.7,22.2 158.8,22.2 158.1,27.1 160.9,27.1		162.8,14.1 160,14.1 	"/> <path d="M168.3,13.8c-1,0-1.9,0.3-2.7,1c-0.8,0.6-1.4,1.6-1.9,2.8s-0.7,2.6-0.7,4c0,1.1,0.2,2.1,0.5,3c0.3,0.9,0.8,1.5,1.4,2		c0.6,0.5,1.3,0.7,2.1,0.7c1.1,0,2-0.3,2.8-1s1.4-1.6,1.8-2.8c0.4-1.2,0.7-2.6,0.7-4c0-1.8-0.4-3.2-1.1-4.2		C170.6,14.3,169.6,13.8,168.3,13.8z M169.1,21.9c-0.2,0.7-0.4,1.2-0.7,1.6c-0.3,0.3-0.6,0.5-1,0.5c-0.4,0-0.7-0.2-1-0.6		c-0.2-0.4-0.4-1-0.4-1.8c0-0.7,0.1-1.4,0.3-2.1c0.2-0.7,0.4-1.2,0.7-1.6c0.3-0.4,0.6-0.6,1-0.6c0.4,0,0.8,0.2,1,0.6		c0.2,0.4,0.3,1,0.3,1.8C169.4,20.5,169.3,21.2,169.1,21.9z"/> <path d="M180.7,15.1c-0.6-0.7-1.3-1-2.4-1h-3.7l-1.9,13h2.8l0.6-4.2h1.3c0.8,0,1.6-0.2,2.2-0.6c0.6-0.4,1.1-1,1.5-1.7		c0.3-0.8,0.5-1.6,0.5-2.6C181.6,16.7,181.3,15.7,180.7,15.1z M178.3,19.6c-0.2,0.3-0.6,0.5-1,0.5h-0.8l0.5-3.2h0.5		c0.4,0,0.6,0.1,0.8,0.4c0.2,0.2,0.3,0.6,0.3,1C178.6,18.8,178.5,19.2,178.3,19.6z"/> </g> </svg>
        </a>
      </h1>
    </div>
  </header>

  <nav class="nav">
    <div class="container nav__container">
      <?php foreach ($categories as $categorie): ?>
        <a class="nav__link active-link" href="<?= $categorie->url ?>"><?= $categorie->content ?></a>
      <?php endforeach ?>
    </div>
  </nav>

  <main class="main">

    <div class="container">
      <!-- <a href="/mon-panier/tout-supprimer" class="btn btn-primary">Delete basket</a> -->
      <!-- <a href="/sandbox?page=45" class="btn btn-primary">Sandbox</a> -->
      <?php dump($_SESSION); ?>
    </div>

    <?= $page_content ?>

  </main>

  <footer class="footer">
    <div class="container">
      <div class="footer__catch-phrase">Fait avec 🧡 et beaucoup de ☕</div>
      <div class="footer__mentions">
        <a class="footer__link active-link" href="/mentions-legales">Mentions légales</a> -
        <a class="footer__link active-link" href="/contact">Contacter-nous</a> -
        ©2019 Yoyote
      </div>
    </div>
  </footer>

</body>
</html>
