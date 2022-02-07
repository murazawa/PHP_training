
<?php

try {
  $id = 159;
  $name = '山田健太';
  $age = 28;
  $gender = '男';
  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境


  $stmt->execute(array(':name' => $name, ':age' => $age, 'gender' => $gender, ':id' => $id));




  $sql = 'UPDATE phpcsv SET name = :name, age = :age, gender = :gender WHERE id = :id';
  $stmt->bindParam( ':id', $id, PDO::PARAM_INT);
  $stmt->bindParam( ':name', $name, PDO::PARAM_STR);
  $stmt->bindParam( ':age', $age, PDO::PARAM_STR);
  $stmt->bindParam( ':gender', $gender, PDO::PARAM_STR);
  $stmt->execute();





  echo "情報を更新しました。";

} catch (Exception $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>更新完了</title>
  </head>
  <body>
  <p>
      <a href="home.php">投稿一覧へ</a>
  </p>
  </body>
</html>
