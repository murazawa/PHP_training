<?php

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require('../app/functions.php');
?>
<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php


  function csvData(){
  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

    $result = 'SELECT * FROM phpcsv';
    $csv_stmt = $PDO->query($result);
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>名前</th>';
    echo '<th>年齢</th>';
    echo '<th>性別</th>';
    echo '</tr>';
    foreach ($csv_stmt as $csvdata) {
      echo '<tr>';
      echo '<td>'.$csvdata["name"].'</td>';
      echo '<td>'.$csvdata["age"].'</td>';
      echo '<td>'.$csvdata["gender"].'</td>';
      echo '</tr>';
    }
    echo '</table>';


    // メールフォーム //
    echo '<form action="mail.php" method="post">';

    // 宛先
    echo '<p><input type="email" name="email" placeholder="メールアドレスを入力してくだい"></p>';

    // 件名
    echo '<input type="hidden" name="subject" value="CSVファイル送付">';
    echo '<p><input type="submit" value="結果をメールで送信"></p>';

    echo '</form>';
    exit;
}

?>
<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- <form action="mail.php" method="post">
  <p><input type="email" name="email" placeholder="メールアドレスを入力してくだい"></p>
  <p><input type="submit" value="結果をメールで送信"></p>
</form> -->


<?php
  $table = "";
  if (isset($_GET['table'])) {
    $table = csvData();
  }
?>



<?php





  try
  {

    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境
    // require ('../app/validate.php');
    // require('../app/resultbtn.php');
    // トランザクション処理
    $PDO->beginTransaction();



      date_default_timezone_set('Asia/Tokyo');
      date_default_timezone_get();

    $done = '../done/';
    $error = '../error/';
    $path = date("Y-m-d H:i:s").'.csv';
    $err_msg= "";
    $tmp_file = $_FILES["csvfile"]["tmp_name"];
    $file_name = $_FILES["csvfile"]["name"];

    if (!empty($tmp_file) && is_uploaded_file($tmp_file)) {



      if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
        move_uploaded_file($tmp_file, $error.'３列方式拡張子失敗_'.$path);
        exit ('選択ファイルには、CSVタイプのファイルを指定してください。');
      }


      $fp = fopen($tmp_file, "r");
      $flag = true;
      while (($data = fgetcsv($fp)) !== FALSE)
      {
        if ($data[1] == "" || $data[2] == "") {
          move_uploaded_file($tmp_file, $error.'３列正式名前、年齢失敗_'.$path);
          exit ('名前、年齢は必須項目です。');
        }
        if (isset($data[4])) {
          move_uploaded_file($tmp_file, $error.'３列正式フォーマット失敗_'.$path);
          exit ('正しいフォーマットで入力してください。');
        }


        if($flag) { $flag = false; continue; }

        $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(1, $data[1], PDO::PARAM_STR);
        $stmt->bindParam(2, $data[2], PDO::PARAM_STR);
        $stmt->bindParam(3, $data[3], PDO::PARAM_STR);
        $stmt->execute();
      } // while 閉じ
      fclose($fp);


      if (move_uploaded_file($tmp_file, $done.'３列正式_'.$path)) { // $done.'３列正式.csv'  ３列正式.csvという名前に変更して保存
        echo 'アップロードに成功しました。</br>';
      } else {
        echo '失敗.....';
      }
    } else {
      exit ('ファイルを選択してください。');
    }
    $result = 'SELECT * FROM phpcsv';
    $csv_stmt = $PDO->query($result);

    $PDO->commit();
  } catch  (PDOException $e) {
    $PDO->rollback();
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>

<p>結果表示ボタンを押下して内容をご確認ください。</p>
<form action="" method="get">
  <p><input type="submit" name="table" value="結果を表示"/></p>
  <!--hiddenあとで-->
</form>


<?php
  include('../app/_parts/_footer.php');

