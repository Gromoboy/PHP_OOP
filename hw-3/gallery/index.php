<?php

//$img_sources = [
//  './img/min/1.jpg' => './img/max/1.jpg',
//  './img/min/2.jpg' => './img/max/2.jpg',
//  './img/min/3.jpg' => './img/max/3.jpg',
//  './img/min/4.jpg' => './img/max/4.jpg',
//  './img/min/ones.txt' => '..'
//];

$img_sources = [];
// получение содержимого папки предосмотра
$img_dir_content = scandir(__DIR__ . '/img/min/');

// наполнение массива ссылками на файлы с окончанием jpg
foreach ($img_dir_content as $dir_item) {
  $dir_item_parts = pathinfo($dir_item);
  if( $dir_item_parts['extension'] !== 'jpg') continue;
  $name = $dir_item_parts['filename'];
  $min_img_path = '/img/min/'.$dir_item;
  $full_img_path = './modal.php?img='.$dir_item;//'/img/max/'.$dir_item;
  $img_sources[$name] = [$min_img_path => $full_img_path];
}
// наполнение шаблона и вывод результата
require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('gallery.tmpl', [
  'img_sources' => $img_sources // передача данных
]);
