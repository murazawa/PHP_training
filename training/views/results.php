<?php

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require('../app/functions.php');
?>

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
    echo '<th>UPDATE</th>';
    echo '<th>DELETE</th>';

    echo '</tr>';
    foreach ($csv_stmt as $csvdata) {
      echo '<tr>';
      echo '<td>'.$csvdata["name"].'</td>';
      echo '<td>'.$csvdata["age"].'</td>';
      echo '<td>'.$csvdata["gender"].'</td>';
      echo '<td>'.'<a href=edit.php?id='.$csvdata["id"].'>更新</a>'.'</td>'; //GETでidを渡している
      echo '<td>'.'<a href=delete.php?id='.$csvdata["id"].'>削除</a>'.'</td>';
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
    echo '<a href="home.php">アップロード画面へ</a>';
    echo '<a href="insert.php">インサート画面へ</a>';
    exit;
}

?>


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

    // トランザクション処理
    $PDO->beginTransaction();



    date_default_timezone_set('Asia/Tokyo');
    date_default_timezone_get();

    $done = '../done/';
    $error = '../error/';
    $path = date("Y-m-d H:i:s").'.csv';
    $err_msg= "";
    $log = 'logs.csv';
    $timestamp = date("Y-m-d H:i:s");

    if (!empty($_FILES["csvfile"]["tmp_name"]) && is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {



      if (pathinfo($_FILES["csvfile"]["name"], PATHINFO_EXTENSION) != 'csv') {
        move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列方式拡張子失敗_'.$path);
        $a = fopen($log, "a");
        fwrite($a, $timestamp." "."Warning:CSVファイルではない". " "."指定したファイルはCSVファイルではありません"."\n");
        fclose($a);
        exit ('選択ファイルには、CSVタイプのファイルを指定してください。');
      }


      $fp = fopen($_FILES["csvfile"]["tmp_name"], "r");
      $flag = true;
      while (($data = fgetcsv($fp)) !== FALSE)
      {
        if ($data[1] == "" || $data[2] == "") {
          move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列正式名前、年齢失敗_'.$path);
          $a = fopen($log, "a");
          fwrite($a, $timestamp." "."Error:３列正式名前、年齢誤り". " "."年齢、性別に誤りがあります"."\n");
          fclose($a);
          exit ('名前、年齢は必須項目です。');
        }
        if (isset($data[4])) {
          move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列正式フォーマット失敗_'.$path);
          $a = fopen($log, "a");
          fwrite($a, $timestamp." "."Error:３列正式フォーマット誤り". " "."フォーマットに誤りがあります"."\n");
          fclose($a);
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


      if (move_uploaded_file($_FILES["csvfile"]["tmp_name"], $done.'３列正式_'.$path)) { // $done.'３列正式.csv'  ３列正式.csvという名前に変更して保存
        $a = fopen($log, "a");
        fwrite($a, $timestamp." "."Success:".$_FILES["csvfile"]["name"]." "."指定したCSVファイルをデータベースに登録しました"."\n");
        fclose($a);

        echo 'アップロードに成功しました。</br>';
      } else {
        echo '失敗.....';
      }
    } else {


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// 次, 結果表示ボタンを展開した状態でアップロードからのデータがある時と無いときで処理を分ける
//  if (empty($id)) {
  // header("Location: home.php");
  // exit;
// }
// 参考



      echo 'ファイルはアップロードされていません';
      $table = "";
      if (isset($_GET['table'])) {
        $table = csvData();
      }
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
<a href="home.php">アップロード画面へ</a>
<a href="insert.php">インサート画面へ</a>

<?php
  include('../app/_parts/_footer.php');

