<?php

$img_sources = [];
// получение содержимого папки предосмотра
$img_dir_content = scandir(__DIR__ . '/img/max/');

// наполнение массива ссылками на файлы с окончанием jpg
foreach ($img_dir_content as $dir_item) {
  $dir_item_parts = pathinfo($dir_item);
  if( $dir_item_parts['extension'] !== 'jpg') continue;
  $img_sources[] = $dir_item;
}

$key = array_search($_GET['img'], $img_sources);
$query = 'modal.php?img=';
// ссылки на предыдущую и следующую картинки
$prev_ref = !empty($img_sources[$key - 1])
  ? $query.$img_sources[$key - 1]
  : $query.array_pop($img_sources);
$next_ref = !empty($img_sources[$key + 1])
  ?$query.$img_sources[$key+1]
  :$query.array_shift($img_sources);

// наполнение шаблона и вывод результата
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('modal.tmpl', [
  'img' => $_GET['img'], // передача данных
  'title' => pathinfo($_GET['img'], PATHINFO_FILENAME),
  'next' => $next_ref,
  'prev' => $prev_ref,
]);
