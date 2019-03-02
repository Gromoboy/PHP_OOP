<?php
function index()
{
  $_SESSION['title'] = 'Заказы';

  $sql = "SELECT id, fio, tel, address, info, status, registeredas FROM zakaz";
  $sql = isAdmin() ? $sql : $sql . " WHERE registeredas = '{$_SESSION['login']}'";
  $res = mysqli_query(connect(), $sql);
  if($res == false) $_SESSION['msg'] = mysqli_error(connect());
  $content = '
  <h1>Список заказов</h1>
  <hr>
  <table style="width:100%">
    <tr>
      <th>№</th>
      <th>ФИО</th>
      <th>Контактный телефон</th>
      <th>Адрес доставки</th>
      <th>Список покупок</th>
      <th>Статус заказа</th>
      <th>Доп.</th>
    </tr>';
  while (list($id, $fio, $tel, $address, $info, $status, $login) = mysqli_fetch_array($res)) {
    $dop = ($login == $_SESSION['login'] and $status == 'в обработке')
      ? "<button onclick=\"delZakaz($id)\">Удалить</button>"
      : '';
    if (isAdmin()) {
      $status = "<input type=\"text\" value=\"$status\"";
      $dop = "<button onclick=\"changeOrderStatus($id)\">Поменять статус</button>";
    }
    // декодирование строки json списка товаров
    // name, price, count - info about byeings 
    $info = json_decode($info, true);
    $prod = '';
    foreach ($info as $val) {
      $prod .= "{$val['name']} - {$val['count']}шт.<br>";
    }
    $content .= <<<php
    <tr id="$id">
      <td>$id</td><td>$fio</td><td>$tel</td><td>$address</td><td>$prod</td><td>$status</td><td>$dop</td>
    </tr>
php;
  }

  $content .='</table>';
  return $content;
}
// функция удаления заказа пользователем при статусе "в обработке"
function del_order() {
  $id = (int)$_REQUEST['id'];
  if (empty($id)) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
  }
  $sql = "SELECT id, registeredas, status FROM zakaz WHERE id = $id";
  $res = mysqli_query(connect(), $sql);
  list($id, $login, $status) = mysqli_fetch_array($res);
  if (empty($id) or $login != $_SESSION['login'] or $status != 'в обработке') {
  echo 'delet error';
  };
  $sql = "DELETE FROM zakaz WHERE id = $id";
  $res = mysqli_query(connect(),$sql);
  $_SESSION['msg'] = $res ? 'Заказ удален' : 'Ошибка удаления заказа';
  echo "заказ успешно удален";
  exit;
}
// ф-я изменения статуса заказа Админом
function change_status() {
  $id = (int)$_REQUEST['id'];
  $data = $_REQUEST['newStatus'];

  $sql = "UPDATE zakaz SET status = '$data' WHERE id = $id";

  $res = mysqli_query(connect(),$sql);
  $msg = $res ? 'Статус обновлен' : 'Ошибка обновления статуса';
  echo "$msg, заказ №$id";
  exit;
}