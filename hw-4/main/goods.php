<?
const DB_DRIVER = 'mysql', DB_HOST = 'localhost', DB_NAME = 'gbphp';
const DSN = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
const DB_USER = 'root', DB_PASS = '';

function index() {
  $_SESSION['title'] = 'Каталог';

  $goodsToShow = 25;
  $limitFrom = isset($_REQUEST['from']) ? $_REQUEST['from'] : 0;
  $qty = isset($_REQUEST['rows']) ? $_REQUEST['rows'] : $goodsToShow;

  $content = '';

  try {
    // PDO обеъект
    $db = new PDO(DSN, DB_USER, DB_PASS);
    $res = $db->query("SELECT * FROM goods LIMIT $limitFrom,$qty");
//    var_dump($db->);
    while ($row = $res->fetch()) {
      $content .= <<<php
    <a href="?page=goods&func=one&id={$row['id']}">{$row['name']}</a><hr>
php;
    }
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }

  // пришел запрос из Javascript через метод Post
  // type: "POST",
  // через Echo возвращаем данные клиенту (метод-событие succes в запросу ajax)
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $content;
    exit;//выход из скрипт
  };

  $content .= <<<EOH
  <button class="add-more" onclick="getMoreGoods($goodsToShow)">Eще</button>
EOH;

  return $content;
}

function one() {
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
