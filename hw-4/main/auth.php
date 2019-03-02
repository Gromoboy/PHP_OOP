<?php

function index()
{
  $_SESSION['title'] = 'Авторизация';

  $a = 'ada';
  $content = <<<php
    <img src="img/img-66df5.jpg" width="200">
    <form method="post" action="?page=auth&func=auth">
        <input type="text" name="login" placeholder="login">
        <input type="text" name="password" placeholder="password">
        <input type="submit">
    </form>
    <hr>
    <br>
    <small>Если у вас нет логина на нашем сайте, </small><a class="ref" href="?page=auth&func=reg"><bold>зарегистрируйтесь ...</bold></a>
    <script> var a = '$a'</script>
    <script src="script.js"></script>
php;
  if (is_logged()) {
    $_SESSION['title'] = 'Личный кабинет';

    $content = <<<php
        <h3>Добро пожаловать в наш магазин, {$_SESSION['name']}!</h3>
        <p>вы авторезированны под логином {$_SESSION['login']}</p>
        <a href="?page=auth&func=logout">Exit</a>
php;
  }
  return $content;
}
// Вывод формф для регистрации нового пользователя на сайте
function reg() {
  $_SESSION['title'] = 'Регистрация';
  $content = <<<html
      <form method="post" action="?page=auth&func=regser">
      <input type="text" name="name" placeholder="Имя">
      <input type="text" name="login" placeholder="Логин">
      <input type="password" name="password" placeholder="Пароль">
      <input type="date" name="dob" placeholder="Дата рождения">
      <fieldset>
        <legend>Адрес доставки</legend>
        <input name="fio" placeholder="fio">
        <input name="tel" placeholder="tel">
        <input name="address" placeholder="address">
      </fieldset>
      <br>
      <input type="submit" value="Зарегистрироваться">
    </form>
html;
  return $content;
}
// TODO: выводить адрес доставки в личном кабинете, при регистрации вносить в базу
// функция регистрации нового пользователя на сервере
function regser() {

  $msg ='';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name']) or empty($_POST['login']) or empty($_POST['password'])) {
      $_SESSION['msg'] = 'Поля "Имя", "Логин" и "Пароль" обязательны для регистрации';
      header('Location: ?page=auth&func=reg');
      exit;
    }
    // проверка логина в базе зарегестрированных пользователей
    $login = clearStr($_POST['login']);
    $sql = "SELECT id
                FROM users
                WHERE login = '$login'";
    $res = mysqli_query(connect(), $sql);
    if (mysqli_num_rows($res) > 0 ) {
      $_SESSION['msg'] = "Пользователь с логином $login уже зарегестрирован на нашем сайте, придумайте новый логин.";

      header('Location: ?page=auth&func=reg');
      exit;
    }

    $name = clearStr($_POST['name']);
    $password = generatePasswordHash($_POST['password']);
    $dob = clearStr($_POST['dob']);
    $delivery_data = [
      'fio' => $_POST['fio'],
      'tel' => $_POST['tel'],
      'address' => $_POST['address']
    ];
    // $delivery_json = json_encode(array_values($delivery_data), JSON_UNESCAPED_UNICODE);
    
    $delivery_json = json_encode($delivery_data, JSON_UNESCAPED_UNICODE);
    $given_required_inputs_notempty = !(empty($login) or empty($name) or empty($password));

    if ($given_required_inputs_notempty) {
      $sql = empty($dob)
        ? "INSERT INTO users (name, login, password, delivery)
                    VALUES ('$name','$login','$password','$delivery_json')"
        : "INSERT INTO `users` (`name`, `login`, `password`, delivery,  `dob`) 
                    VALUES ('$name', '$login', '$password', '$delivery_json' , '$dob')";
      $res = mysqli_query(connect(),$sql);
      $msg = $res ? 'Новый пользователь добавлен' : 'Ошибка регистрации в бд '.mysqli_errno(connect());
    } else $msg = 'Введены неккоректные данные';
  }
  $_SESSION['msg'] = $msg;
  header('Location: ?page=auth');
  exit;
}

function auth()
{
  $msg = 'Что-то пошло не так';
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['login']) || empty($_POST['password'])) {
      $_SESSION['msg'] = 'Не все параметры переданы';
      header('Location: ?page=auth');
    }
    $login = clearStr($_POST['login']);

    $sql = "SELECT id, login, password, name, role
                FROM users
                WHERE login = '$login'";
    $res = mysqli_query(connect(), $sql);
    $row = mysqli_fetch_assoc($res);
    $passwordGiven = generatePasswordHash($_POST['password']);
//        $passwordSql = '21db9c15a75962a0865d5a39fe7fb9ff';
    $passwordHashServerside = $row['password'];
    if ($passwordGiven == $passwordHashServerside) {
      $_SESSION['login'] = $login;
      $_SESSION['name'] = $row['name'];
      if ($row['role']) $_SESSION['isAdmin'] = 'YES';
      $msg = '';
    }
  }
  $_SESSION['msg'] = $msg;
  header('Location: ?page=auth');
  exit;

}

function logout()
{
  session_destroy();
  header('Location: ?page=auth');
  exit;
}