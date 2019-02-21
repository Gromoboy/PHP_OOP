<?php

trait Singleton {
  private static  $instance;

  final private function __construct() {}
  final private function __clone() {}
  final private function __wakeup() {}

  final public static function getInstance() {
    if(empty(self::$instance)) {
      self::$instance = new self();
    }
    return self::$instance;
  }
}

class SingletonClass {
  use Singleton;

  public function Hello() {
    echo 'Hello world';
  }

}

$singelton  = SingletonClass::getInstance(); 
var_dump($singelton);
$singelton2 = SingletonClass::getInstance();
var_dump($singelton2);

$singelton2->Hello();
