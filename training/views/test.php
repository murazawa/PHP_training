<h1>ん</h1>
<?php

try {

  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境
  $sql = 'UPDATE phpcsv SET name = :name, age = :age, gender = :gender WHERE id = :id';
  $stmt = $PDO->prepare($sql);




  echo 'DB接続したよ';
} catch (PDOException $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}






?>
