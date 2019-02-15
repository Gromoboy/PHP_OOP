<?php
//1. Придумать класс, который описывает любую сущность из предметной области
//интернет-магазинов: продукт, ценник, посылка и т.п.
//2. Описать свойства класса из п.1 (состояние).
//3. Описать поведение класса из п.1 (методы).
//4. Придумать наследников класса из п.1. Чем они будут отличаться?
class Product
{
  private $name;
  private $price;
  private $photo;
  private $description;

  function __construct($name, $price, $photo, $description) {
    $this->name = $name;
    $this->price = $price;
    $this->photo = $photo;
    $this->description = $description;
  }

  function setName($name) {
    $this->name = $name;
  }

  function GetName() {
    return $this->name;
  }

  function setPrice($price = '0.00') {
    $this->price = (int)$price;
  }

  function GetPrice() {
    return $this->price;
  }

  function setPhoto($photo) {
    $this->photo = $photo;
  }

  function GetPhoto() {
    return $this->photo;
  }

  function setDesc($description) {
    $this->description = $description;
  }

  function GetDesc() {
    return $this->description;
  }

}