<?php
function index()
{
  $_SESSION['title'] = 'Корзина';
  if (empty($_SESSION['goods'])) {
    return 'Корзина пуста';
  }

  $content = '';
  $overall = 0;
  foreach ($_SESSION['goods'] as $id => $good) {
    $overall += $good['price'] * $good['count'];// подсчет итоговой суммы корзины
    $content .= <<<php
<h2>{$good['name']}</h2>
<p>{$good['price']}р.</p>
<p>
    <a href="?page=backet&func=del&id={$id}">-</a>    
        {$good['count']}
    <a href="?page=backet&func=add&id={$id}">+</a>
</p>
php;
  }
  $content .= "<hr><h3 class=overall>Общая цена: $overall руб.</h3>";
  //Заказ без реги или с оной
  $content .= empty($_SESSION['login']) ? get_html_form_for_delivery() : get_cart_order_html_btn();

  return $content;
}

function get_html_form_for_delivery() {
  return <<<php
      <h2>Заказать</h2>
  <form method="post" action="?page=backet&func=zakaz">
      <input name="fio" placeholder="fio">
      <input name="tel" placeholder="tel">
      <input name="address" placeholder="address">
      <input type="submit" value="Оформить заказ без регистрации">
  </form>  
php;
}

function get_cart_order_html_btn() {
  return '<a href="?page=backet&func=zakaz" class="btn">Оформить заказ</a>';
}

function add()
{
  $id = (int)$_GET['id'];
  $msg = 'Что-то пошло не так...';
  if (!empty($id)) {
    $sql = "SELECT id, name, info, price FROM goods WHERE id = $id";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);
    if (!empty($row)) {
      $item = [
        'price' => $row['price'],
        'name' => $row['name'],
      ];
      if (empty($_SESSION['goods'][$id])) {
        $item['count'] = 1;
        $_SESSION['goods'][$id] = $item;
      } else {
        $_SESSION['goods'][$id]['count'] += 1;
      }
      $msg = 'Товар добавлен';
    }
  }
  if ($_SERVER['HTTP_REFERER'] == 'http://public/?page=backet') {
    $msg = '';
  }
  // пришел запрос из Javascript через метод Post
  // type: "POST",
  // url: "?page=backet&func=addajax&id=" + id,
  // через Echo возвращаем данные клиенту (метод-событие succes в запросу ajax)
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo getCartCountBadge(count($_SESSION['goods']));

    exit;//выход до посылки заголовка
  }

  $_SESSION['msg'] = $msg;
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}

function del()
{
  $id = (int)$_GET['id'];
  $msg = 'Что-то пошло не так...';
  if (!empty($id)) {
    if (!empty($_SESSION['goods'][$id])) {
      if ($_SESSION['goods'][$id]['count'] != 1) {
        $_SESSION['goods'][$id]['count'] -= 1;
      } else {
        unset($_SESSION['goods'][$id]);
      }
    }
  }
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}

function addajax()
{
  add();
}

function zakaz()
{
  $msg = 'Что-то пошло не так...';
  $is_order_without_reg = $_SERVER['REQUEST_METHOD'] == 'POST';
  
  if ($is_order_without_reg) {
    
    $fio = clearStr($_POST['fio']);
    $tel = clearStr($_POST['tel']);
    $address = clearStr($_POST['address']);
    
    $dont_have_all_data = empty($fio) or empty($tel) or empty($address);
    
    if ($dont_have_all_data) {
      $_SESSION['msg'] = 'Пожалуйста, введите все данные для доставки товара';
      header('Location: ?page=backet');
      exit;
    }
    
  } else {
    $loggedas = $_SESSION['login'];
    $sql = "SELECT delivery FROM users WHERE login = '$loggedas'";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);
    $delivery_info = json_decode($row['delivery'], true);
    $fio = $delivery_info['fio'];
    $tel = $delivery_info['tel'];
    $address = $delivery_info['address'];
  }
  $info = json_encode(array_values($_SESSION['goods']), JSON_UNESCAPED_UNICODE);
  
  $sql = empty($_SESSION['login']) 
    ? "INSERT INTO zakaz(fio, tel, address, info, status) 
      VALUES ('$fio', '$tel', '$address', '$info', 'в обработке')"
    : "INSERT INTO zakaz(fio, tel, address, info, status, registeredas) 
      VALUES ('$fio', '$tel', '$address', '$info', 'в обработке', '$loggedas')";
  $is_inserted = mysqli_query(connect(), $sql);
  if ($is_inserted) {
    $msg = 'Ваш заказ принят, ждите звонка';
    unset($_SESSION['goods']);
  } else $msg .='ошибка бд №'.mysqli_errno(connect()).mysqli_error(connect());

  $_SESSION['msg'] = $msg;
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}