<?php
  try
  {
    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root'); // MAMP環境
    echo 'DBに接続したよ</br>';
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }


  require ('../app/functions.php');
  require ('../app/validate.php');

  include ('../app/_parts/_header.php');


?>

<p>CSVをデータベースに登録します</p>

<form action="results.php" method="post" enctype="multipart/form-data">

  <p><input type="file" name="csvfile"/></p>
  <!--hiddenあとで-->
  <p><input type="submit" value="アップロード"></p>
</form>



<?php
  include('../app/_parts/_footer.php');
