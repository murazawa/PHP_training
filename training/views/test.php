<h1>ん</h1>
<?php

try {

  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境
  $sql = 'UPDATE phpcsv SET name = :name, age = :age, gender = :gender WHERE id = :id';
  $stmt = $PDO->prepare($sql);

  $params = array(':name' => $_POST['name'], ':age' => $_POST['age'], ':gender' => $_POST['gender'], ':id' => $_POST['id']);
  $stmt->execute($params);



  echo '更新完了しました';


  header("Locatiion: results.php");
  exit;




  echo '接続したよ';
} catch (PDOException $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}






?>
