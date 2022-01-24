<?php

ini_set('display_errors', "On");
include('../app/_parts/_header.php');
require('../app/functions.php');
  try
  {
    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境
    // require ('../app/validate.php');
    // require('../app/resultbtn.php');
    // トランザクション処理
    $PDO->beginTransaction();


    $err_msg= "";

    if (!empty($_FILES["csvfile"]["tmp_name"]))
    {
      $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
      $file_name = $_FILES["csvfile"]["name"];

////////////////////////////// 拡張子チェック /////////////////////////////////////////////////////////////
      if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv')
      {
        $err_msg = '選択ファイルには、CSVタイプのファイルを指定してください。';
/////////////////////////////////////////////////////////////////////////////////////////////////////////
      } else {

          $fp = fopen($file_tmp_name, "r");

          $flag = true;
          while (($data = fgetcsv($fp)) !== FALSE)

          {
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// キーチェック //////////////////////////////////////////////////////////////////
            if ($data[1] == "" || $data[2] == "")
            {
              exit ('名前、年齢は必須項目です。');
            }
/////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// フォーマットチェック /////////////////////////////////////////////////////////////
            if (isset($data[4]))
            {
              exit ('正しいフォーマットで入力してください。');
            }
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

              if($flag) { $flag = false; continue; }

              $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
              $stmt = $PDO->prepare($sql);
              $stmt->bindParam(1, $data[1], PDO::PARAM_STR);
              $stmt->bindParam(2, $data[2], PDO::PARAM_STR);
              $stmt->bindParam(3, $data[3], PDO::PARAM_STR);
              $stmt->execute();
          }

          fclose($fp);
          echo 'アップロードに成功しました。</br>';
      }
    } else {
      $err_msg = 'ファイルを選択してください。';
    }
    echo $err_msg;
    echo 'DBに接続したよresult.php</br>';
    $result = 'SELECT * FROM phpcsv';
    $csv_stmt = $PDO->query($result);

    $PDO->commit();
  } catch  (PDOException $e) {
    $PDO->rollback();
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>

<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<?php function csvData(){
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

}

?>
<!--////////////////////////////////////////////////////////////////////////////////////////////////-->
<!-- <form action="mail.php" method="post">
  <p><input type="email" name="email" placeholder="メールアドレスを入力してくだい"></p>
  <p><input type="submit" value="結果をメールで送信"></p>
</form> -->

<p>結果表示ボタンを押下して内容をご確認ください。</p>
<form action="results.php" method="post">
  <p><input type="submit" name="table" value="結果を表示"/></p>
  <!--hiddenあとで-->
</form>


<?php
  $table = "";
  if (isset($_POST['table'])) {
    $table = csvData();
  }
?>

<!-- <input type="hidden" name="message"> -->
<!-- <button onclick="csvData();"> 結果を表示 </button> -->

<?php
  include('../app/_parts/_footer.php');
