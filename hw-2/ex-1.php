<?php

abstract class ABook
{
  private $title;
  private $author;
  private $cost;

  function __construct($title, $author, $cost){
    $this->setTitle($title);
    $this->setAuthor($author);
    $this->setCost($cost);
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function getAuthor() {
    return $this->author;
  }

  public function setAuthor($author) {
    $this->author = $author;
  }

  public function getCost() {
    return $this->cost;
  }

  public function setCost($cost) {
    $this->cost = $cost;
  }

  abstract function getPrice();

  function getProfit() {
    return $this->getPrice() - $this->getCost();
  }
}

class Book extends ABook
{
  const STANDARD_MARKUP = 1.2;

  function __construct($title, $author, $cost) {
    parent::__construct($title, $author, $cost);
  }

  function getPrice() {
    return $this->getCost() * self::STANDARD_MARKUP;
  }
}
class DigitalBook extends ABook
{
  const DIGITAL_MARKUP = 1.5;

  public function __construct(Book $book) {
    parent::__construct(
      $book->getTitle(), 
      $book->getAuthor(), 
      $book->getCost() / 2
    );
  }

  public function getPrice() {
    return $this->getCost() * self::DIGITAL_MARKUP;
  }
}


class UsedBook extends ABook
{
  private $weight;
  const JUNK_PAPER_PRICE = 2;

  public function  __construct( $title, $author, $costPerWeight, $weight ) {
    $cost = $costPerWeight * $weight;
    parent::__construct($title, $author, $cost);
    $this->setWeight($weight);
  }

  public function setWeight($weight) {
    $this->weight = $weight;
  }


  public function getPrice() {
    return $this->weight * self::JUNK_PAPER_PRICE;
  }

}

$book = new Book('Приключения Незнайки', 'Носов', 10);
echo $book->getTitle().PHP_EOL, $book->getPrice().PHP_EOL, $book->getProfit().PHP_EOL;
var_dump($book);

$eBook = new DigitalBook($book);
echo $eBook->getTitle().PHP_EOL, $eBook->getPrice().PHP_EOL, $eBook->getProfit().PHP_EOL;
var_dump($eBook);

$usedBook = new UsedBook ('Путешествие в Авс...', '', 3, 0.3);
echo $usedBook->getTitle().PHP_EOL, $usedBook->getPrice().PHP_EOL, $usedBook->getProfit().PHP_EOL;
var_dump($usedBook);