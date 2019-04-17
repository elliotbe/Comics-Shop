<?php

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

function getUrl(string $name, array $params = []) :string {
  global $router;
  return $router->url($name, $params);
}
