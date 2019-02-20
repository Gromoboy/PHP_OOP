<?php
class Monowheel extends Product
{
  private $diameter;
  private $model;

  function __construct($name, $price, $photo, $description, $diameter, $model) {
    parent::__construct($name, $price, $photo, $description);
    $this->diameter = $diameter;
    $this->model = $model;
  }

  function getDiameter () {
    return $this->diameter;
  }
  function getModel() {
    return $this->model;
  }
  function showInfo() {
    echo "$this->name $this->model цена: $this->price руб.";
  }
}
