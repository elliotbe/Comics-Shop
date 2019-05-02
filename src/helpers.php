<?php
declare(strict_types = 1);

function slugify(string $string, string $delimiter = '-') :string {
  $old_locale = setlocale(LC_ALL, '0');
  setlocale(LC_ALL, 'en_US.UTF-8');
  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
  $clean = preg_replace('#[^a-zA-Z0-9/_|+ -]#', '', $clean);
  $clean = strtolower($clean);
  $clean = preg_replace('#[/_|+ -]+#', $delimiter, $clean);
  $clean = trim($clean, $delimiter);
  setlocale(LC_ALL, $old_locale);
  return $clean;
}

function generateUrl(string $name, array $params = []) :string {
  global $router;
  return $router->url($name, $params);
}

function printLine(string $arg) :void {
  echo "$arg\n";
}

function preDump(...$args) :void {
  echo '<pre>';
  foreach ($args as $arg) {
    echo $arg;
  }
  echo '</pre>';
}

function setPageName(?string $page_name) :string {
  $site_name = 'Comics Shop';
  if (is_null($page_name)) {
    return $site_name;
  }
  return "$page_name | $site_name";
}

function capitalize(string $string) :string {
  return ucwords(strtolower($string));
}

function redirect(string $url) :void {
  header("Location: $url");
}

function getRandomGif() :string {
  $gif_folder = array_slice(scandir(ROOT . 'public/media/error/'), 2);
  $number_of_gif = count($gif_folder);
  $random_gif = $gif_folder[rand(0, $number_of_gif - 1)];
  return "/media/error/$random_gif";
}
