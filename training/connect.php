<?php

  function connect() {
    try
    {
      // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
      $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

      return $PDO;
      // echo 'DBに接続したよ</br>';

    } catch  (PDOException $e) {
      echo 'DB接続エラー:'.$e->getMessage();
    }
  }
