<?php
declare(strict_types = 1);

function slugify(string $string, string $delimiter = '-') :string {
  $old_locale = setlocale(LC_ALL, '0');
  setlocale(LC_ALL, 'en_US.UTF-8');
  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
  $clean = preg_replace('#[^a-zA-Z0-9/_|+ -]#', '', $clean);
  $clean = mb_strtolower($clean);
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
  if (php_sapi_name() === 'cli') {
    $eol = "\n";
  } else {
    $eol = '<br>';
  }
  echo "{$arg}{$eol}";
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
  $string = mb_strtolower($string);
  $string = preg_replace_callback("#([^ .'])+#", function ($match) use ($string) {
    $words_ignore_list = [
      'les', 'l', 'le', 'la', 'a', 'à', 'au', 'et', 'd',
      'de', 'chez', 'que', 'du', 'un', 'une', 'des', 'the'
    ];
    if (in_array($match[0], $words_ignore_list) && mb_strpos($string, $match[0]) !== 0) {
      return $match[0];
    }
    return mb_convert_case($match[0], MB_CASE_TITLE);
  }, $string);
  return $string;
}


function mb_explode(string $string) :array {
  $array = array_map(function ($char) use ($string) {
    return mb_substr($string, $char, 1);
  }, range(0, mb_strlen($string) - 1));
  return $array;
}

function lastPageUrl() :string {
  $current_page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $referer = $_SERVER['HTTP_REFERER'] ?? null;
  if ($referer !== null && $referer !== $current_page ) {
    return $referer;
  }
  return '/';
}

function redirect(string $url) :void {
  header("Location: $url", true, 303);
  die();
}

function sendBack() :void {
  redirect(lastPageUrl());
}

function getRandomGif() :string {
  $gif_folder = array_slice(scandir(ROOT . 'public/media/error/'), 2);
  $number_of_gif = count($gif_folder);
  $random_gif = $gif_folder[rand(0, $number_of_gif - 1)];
  return "/media/error/$random_gif";
}

function escapeSQL($string) :string {
  $string = str_replace('`', '``', $string);
  return "`$string`";
}

function snakeToCamel(string $name) :string {
  $name = explode('_', $name);
  $name = array_map(function ($name_part) use ($name) {
    return $name[0] !== $name_part ? ucfirst($name_part) : $name_part;
  }, $name);
  $name = implode('', $name);
  return $name;
}

function camelToSnake(string $name) {
  $name = str_split($name);
  $name = array_map(function ($char) {
    return ctype_upper($char) ? '_' . mb_strtolower($char) : $char;
  }, $name);
  $name = implode('', $name);
  return $name;
}

function getBasketCount() :int {
    $basket = App::session()->get('basket') ?? [];
    return sizeof($basket);
}

function parseFloat(float $number) :string {
  return str_replace('.', ',', sprintf('%0.2f', $number));
}

function generateToken(int $length = 128) :string {
  return substr(hash('sha512', (string)rand()), 0, $length);
}
