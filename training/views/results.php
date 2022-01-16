<?php
ini_set('display_errors', "On");
// require ('../app/functions.php');
// require ('../app/validate.php');

// $csvFile = filter_input(INPUT_POST, "名前", "年齢", "性別", FILTER_SANITIZE_SPECIAL_CHARS);

// データベース接続
try {
  $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root');
  // $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示

  // home.phpの値を取得
  $name = $_POST['name'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  var_dump($name);
  var_dump($age);
  var_dump($gender);
  // INSERT文を変数に格納。:名前や:年齢はプレースホルダという、値を入れるための単なる空箱
  $sql = 'INSERT INTO phpcsv ("名前", "年齢", ":性別") VALUES (?, ?, ?)';
  $stmt = $PDO->prepare($sql); // 挿入する値は空のまま、SQL実行の準備する
  $stmt->bindValue(':名前', $name, PDO::PARAM_STR);
  $stmt->bindValue(':年齢', $age, PDO::PARAM_INT);
  $stmt->bindValue(':性別', $gender, PDO::PARAM_STR);
  // $params = array(':名前' => $name, ':年齢' => $age, ':性別' => $gender);
  $stmt->execute(); // 挿入する値が入った変数をexecuteにセットしてSQLを実行


  echo '登録しました。'; // 登録完了のメッセージ
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}




// $stmt = $db->prepare('INSERT INTO phpcsv ("名前", "年齢", "性別") VALUES(?,?,?)');
// if (!$db->error):
//   die($db->error);
// endif;

// $stmt->bind_param($csvFile);
// $ret = $stmt->execute();

// if ($ret):
//   echo '登録されました。';
// else:
//   echo $db->error;
// endif;

// include ('../app/_parts/_header.php');
// var_dump($csvFile);
?>

