<?php


class DataBaseSingleton
{
  const DSN = 'mysql:host=localhost;dbname=gbphp';
  const LOGIN = 'root';
  const PASSWORD = '';
  private static $instance;

  final private function __construct() {
  }

  final private function __clone() {
  }

  final private function __wakeup() {
  }

  final public static function getInstance() {
    if (empty(self::$instance)) {
      self::$instance = new PDO(self::DSN, self::LOGIN, self::PASSWORD);
    }
    return self::$instance;
  }
}
