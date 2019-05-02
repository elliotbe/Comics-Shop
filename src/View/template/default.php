<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= setPageName($page_name) ?></title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header class="header">
    <div class="container header__container">
      <h1 class="logo"><a href="/">Comics Shop</a></h1>
      <a class="header__link" href="">Connexion / Inscription</a>
      <a class="header__link" href="">Panier</a>
    </div>
  </header>
  <nav class="nav">
      <div class="container nav__container">
        <?php foreach ($categories as $categorie): ?>
          <a class="nav__link" href=
            "<?= generateUrl(
              'Product#byColumn', [
                'column' => 'category',
                'id' => $categorie->id,
                'slug' => $categorie->slug
            ]) ?>"
          ><?= $categorie->content ?></a>
        <?php endforeach ?>
      </div>
  </nav>

  <main class="main">
    <?= $page_content ?>
  </main>

  <footer class="footer">
    FOOTER
  </footer>

</body>
</html>
