<?
function index()
{
  $_SESSION['title'] = 'Каталог';
  
  $goodsToShow = 25;
  $limitFrom = isset($_REQUEST['from']) ? ' LIMIT '.$_REQUEST['from'].', ' : ' LIMIT ';
  $qty = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : $goodsToShow;

  $sql = "SELECT id, name, info, price FROM goods".$limitFrom.$qty;
  // var_dump($sql);
  $res = mysqli_query(connect(), $sql);
  $content = '';
  while ($row = mysqli_fetch_assoc($res)) {
    $content .= <<<php
    <a href="?page=goods&func=one&id={$row['id']}">{$row['name']}</a><hr>
php;
  }
  // пришел запрос из Javascript через метод Post
  // type: "POST",
  // через Echo возвращаем данные клиенту (метод-событие succes в запросу ajax)
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $content;

    exit;//выход из скрипт
  };

  $content .= <<<EOH
  <button class="add-more" onclick="getMoreGoods($goodsToShow)">Eще</button>;
EOH;

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
