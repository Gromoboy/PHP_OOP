<?php
session_start();

include ('config.php');


$page  = ! empty($_GET['page'])  ? $_GET['page']   : 'index';
$func  = ! empty($_GET['func'])  ? $_GET['func']   : 'index';

$dir = __DIR__ . '/';

if (! file_exists($dir . $page . '.php')){
    $page = 'index';
}

include ($dir . $page . '.php');

if (! function_exists($func)){
    $func = 'index';
}
$content = $func();
$title = getTitle();
if (empty($title)) $title = 'Магаз';
$private = is_logged()
  ? $_SESSION['login']
  : 'Авторизоваться';
$orders = is_logged() ? 'Заказы' : '';

$template = file_get_contents($dir . 'tmpl/' . template() );
  $qtyGoods = empty($_SESSION['goods']) ? '' : getCartCountBadge(count($_SESSION['goods']));

	$newDate = [
        '{CONTENT}' => $content,
        '{___MSG_}' => getMsg(),
        '{__COUNT}' => $qtyGoods,
        '{__TITLE}' => $title,
        '{PRIVATE}' => $private,
        '{_ORDERS}' => $orders
    ];

  echo strtr($template, $newDate);