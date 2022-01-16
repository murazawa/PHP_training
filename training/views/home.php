<?php
  try
  {
    $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root');
    echo 'DBに接続したよ</br>';
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }

  // $ret = $pdo->query('INSERT INTO phpcsv (名前, 年齢, 性別) VALUES ("山田太郎", 36, "男")');
  // if ($ret):
  //   echo 'データを挿入しました';
  // else:
  //   echo $pdo->error;
  // endif;




  // INSERT INTO `phpcsv`(`名前`, `年齢`, `性別`) VALUES ('佐々木太郎',23,'男')

  require ('../app/functions.php');
  require ('../app/validate.php');

  include ('../app/_parts/_header.php');


?>

<p>CSVをデータベースに登録します</p>

<form action="results.php" method="post">
  <p><input type="text" name="name"/></p>
  <p><input type="text" name="age"/></p>
  <p><input type="text" name="gender"/></p>

  <!-- <p><input type="file" name=""/></p> -->
  <!--hiddenあとで-->
  <p><button type="submit">アップロード</button></p>
</form>



<?php
  include('../app/_parts/_footer.php');
