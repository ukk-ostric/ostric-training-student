<?php

class Product
{
  protected $title;
  protected $price;
  protected $stock;

  public function __construct($title, $price, $stock)
  {
    $this->title = $title;
    $this->price = $price;
    $this->stock = $stock;
  }

  public function getStock()
  {
    return $this->stock;
  }

  public function purchase(EMoney $money, $pin)
  {
    if ($this->stock > 0) {
      if ($money->getBalance() >= $this->price) {
        if ($money->withdraw($this->price, $pin) == TRUE) {
          $this->stock -= 1;
          echo "<br>";
          echo "Pembelian Berhasil";
        }
      } else {
        echo "<br>";
        echo "Saldo Anda Kurang";
      }
    } else {
      echo "<br>";
      echo "Produk kosong";
    }
  }
}


class Clotesh extends Product
{
  protected $brand;
  protected static $arrClotesh = array();

  public function __construct($title, $price, $stock, $brand)
  {
    parent::__construct($title, $price, $stock);
    $this->brand = $brand;
    array_push(
      Clotesh::$arrClotesh,
      [
        'title' => $this->title,
        'price' => $this->price,
        'stock' => $this->stock,
        'brand' => $this->brand
      ]
    );
  }

  public function purchase(EMoney $money, $pin)
  {

    parent::purchase($money, $pin);
    $i = 0;
    foreach (Clotesh::$arrClotesh as $clotesh) {
      if ($this->title == $clotesh['title']) {
        Clotesh::$arrClotesh[$i]['stock'] = $this->stock;
      }
      $i++;
    }
  }

  public function getInfoProduct()
  {
    echo "Title : {$this->title} | Harga : {$this->price} | Stock : {$this->stock} | Brand : {$this->brand}";
  }

  public function showProduct()
  {
    echo "<br>";
    echo "====List Clotesh====";
    echo "<br>";

    foreach (Clotesh::$arrClotesh as $clotesh) {
      echo "Title : {$clotesh['title']} | Harga : {$clotesh['price']} | Stock : {$clotesh['stock']} | Brand : {$clotesh['brand']}";
      echo "<br>";
    }
  }
}

class Book extends Product
{
  protected $penulis;
  protected static $arrBook = array();

  public function __construct($title, $price, $stock, $penulis)
  {
    parent::__construct($title, $price, $stock);
    $this->penulis = $penulis;
    array_push(
      Book::$arrBook,
      [
        'title' => $this->title,
        'price' => $this->price,
        'stock' => $this->stock,
        'penulis' => $this->penulis
      ]
    );
  }

  public function purchase(EMoney $money, $pin)
  {

    parent::purchase($money, $pin);
    $i = 0;
    foreach (Book::$arrBook as $clotesh) {
      if ($this->title == $clotesh['title']) {
        Book::$arrBook[$i]['stock'] = $this->stock;
      }
      $i++;
    }
  }

  public function getInfoProduct()
  {
    echo "Title : {$this->title} | Harga : {$this->price} | Stock : {$this->stock} | Penulis : {$this->penulis}";
  }

  public function showProduct()
  {
    echo "<br>";
    echo "====List Book====";
    echo "<br>";

    foreach (Book::$arrBook as $clotesh) {
      echo "Title : {$clotesh['title']} | Harga : {$clotesh['price']} | Stock : {$clotesh['stock']} | Penulis : {$clotesh['penulis']}";
      echo "<br>";
    }
  }
}

class EMoney
{
  private $name;
  private $accountNumber;
  private $balance;
  private $pin;

  public function __construct($name, $accountNumber, $balance, $pin)
  {
    $this->name = $name;
    $this->accountNumber = $accountNumber;
    $this->balance = $balance;
    $this->pin = $pin;
  }

  public function getBalance()
  {
    return $this->balance;
  }

  public function deposit($balance)
  {
    $this->balance += $balance;
  }

  public function withdraw($balance, $pin)
  {
    if ($this->pin == $pin) {
      if ($this->balance >= $balance) {
        $this->balance -= $balance;
        echo "<br>";
        echo "Penarikan sejumlah " . $balance . " berhasil";
        echo "<br>";
        return true;
      } else {
        echo "<br>";
        echo "Saldo anda kurang";
        echo "<br>";
        return false;
      }
    } else {
      echo "<br>";
      echo "pin anda salah";
      echo "<br>";
      return false;
    }
  }
}

$clotesh1 = new Clotesh("Baju hypebeast", 100000, 2, "Supreme");
$clotesh2 = new Clotesh("Baju muslim kekinian", 80000, 3, "Rabbani");
$clotesh3 = new Clotesh("Baju renang", 50000, 2, "Nike");

$book1 = new Book("The magic of thinking big", 50000, 2, "David Schwarz");
$book2 = new Book("Rich Dad Poor Dad", 60000, 2, "Robert T Kiyosaki");

$clotesh1->showProduct();
$book1->showProduct();

$user1 = new EMoney("Chandra", 1803815, 50000, 123456);
$user1->deposit(300000);

$clotesh1->purchase($user1, 123456);
$clotesh1->purchase($user1, 123456);
$clotesh2->purchase($user1, 123456);

$book1->purchase($user1, 123456);
$book2->purchase($user1, 123456);

echo "<br> Stock:" . $clotesh1->getStock();
$clotesh1->showProduct();
$book2->showProduct();
