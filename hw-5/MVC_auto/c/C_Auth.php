<?php
//
// Контроллер авторизации
//
include_once('m/config.php');

class C_Auth extends C_Base
{
   const SOL = 'b07152d234b79075b9640';

  private function generatePasswordHash($str) {
    return strtoupper(md5($str . self::SOL));
  }

  private function showError($error) {

    $this->content = $this->Template('v/v_login.php', ['error' => $error]);
  }

  public function action_index() {
    if ($this->is_logged()) {
      $this->setTitle("::Личный кабинет ") ;
      $pagesList = '';
      $history = array_slice($this->getTitlesHistory(), -5);
      foreach ($history as $title) {
        $pagesList .= '<li>'.$title.'</li>';
      }
//      $pagesList .='</ul';
      $this->content = $this->Template('v/v_account.php', [
        'login' => $this->getLogin(),
        'name' => $this->getUserName(),
        'pageHistory' => $pagesList
      ]);
//      $this->auth = '@'.$this->getLogin();
      return;
    }
    $this->setTitle('::Авторизация');
    $this->content = $this->Template('v/v_login.php');
  }


  public function action_auth() {
//    $this->title .= '::Авторизация';
    //defence
    if (empty($_POST['login']) || empty($_POST['password'])) {
      $this->showError('Не все параметры введены, введите и логин и пароль');
      return;
    }
    $db = DataBaseSingleton::getInstance();
    $stmt = $db->prepare("SELECT login, password, name, role
                FROM users
                WHERE login = ?"
    );
    $stmt->execute([$_POST['login']]);
    $user = $stmt->fetch();

    if (empty($user)) {
      $this->showError("Пользователя с таким логином не зарегестрировано, либо пароль не верен");
      return;
    }
    //проверка пароля
    $givenPassword = $this->generatePasswordHash($_POST['password']);
    $passwordHashServer = $user['password'];
    if ($givenPassword != $passwordHashServer) {
      $this->showError("Введенный пароль не соответствует логину");
      return;
    }
    // login: admin password: 123
    $_SESSION['login'] = $user['login'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['admin'] = (bool) $user['role'];
//    echo $_SERVER["HTTP_REFERER"];
    header('location: ?c=auth');
  }

  public function action_logout() {
    session_destroy();
    header('location: ?c=auth');
  }
}
