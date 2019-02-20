<?php
// Что он выведет на каждом шаге? Почему?
  class A {
      public function foo() {
          static $x = 0;
          echo ++$x;
      }
  }
  class B extends A {
  }
  $a1 = new A;
  $b1 = new B;
  $a1->foo(); 
  $b1->foo(); 
  $a1->foo(); 
  $b1->foo(); 
  // вывод аналогичен предыдущему заданию №6 (1122)
  // Отличие данного примера в том что классы создаются без скобок (new A, new B вместо new A() , new B())
  // В PHP если при создании объекта в конструктор не передаются параметры - скобки можно опустить.
  // Так что два последних примера полностью аналогичны