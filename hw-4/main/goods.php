<?
function index()
{
  $_SESSION['title'] = 'Каталог';

  $limit = isset($_GET['rows']) ? ' LIMIT '.$_GET['rows'] : ' LIMIT 5';
  $sql = "SELECT id, name, info, price FROM goods".$limit;
  $res = mysqli_query(connect(), $sql);
  $content = '';
  while ($row = mysqli_fetch_assoc($res)) {
    $content .= <<<php
    <a href="?page=goods&func=one&id={$row['id']}">{$row['name']}</a><hr>
php;
    // <button onclick=""

  }

  return $content;
}

function one()
{
  $id = (int)$_GET['id'];
  $sql = "SELECT id, name, info, price FROM goods WHERE id = $id";
  $res = mysqli_query(connect(), $sql);
  $content = '<a href="?page=goods">Все товары</a><br><br><br>';


  $row = mysqli_fetch_assoc($res);
  $_SESSION['title'] = $row['name'];
  $content .= <<<php
			<h1>{$row['name']}</h1>
			<p style="color: red; cursor: pointer" onclick="send({$id})">Добавить</p>
			<p>{$row['price']}р.</p>
			<p>{$row['info']}</p>

php;

  return $content;
}
