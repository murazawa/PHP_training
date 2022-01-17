<?php
ini_set('display_errors', "On");
// require ('../app/functions.php');
// require ('../app/validate.php');



// データベース接続
// $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  // $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root'); // ZAMP環境


  try
  {
    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root'); // MAMP環境

    if (isset($_FILES["csvfile"]["tmp_name"]))
    {
      $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
      $file_name = $_FILES["csvfile"]["name"];

      if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv')
      {
        $err_msg = 'CSVのみ対応しています';
      } else {
          $fp = fopen($file_tmp_name, "r");

          // 配列に変換する
          $csv_data = [];
          while (($data = fgetcsv($fp)) !== FALSE)
          {
            $csv_data[] = $data;
          }
          fclose($fp);

        // if (move_uploaded_file($file_tmp_name, "../data/".$file_name))
        // {
        //   chmod("../data".$file_name, 0644);
        //   $msg = $file_name."をアップロードしました。";
        //   $file = '../data/'.$file_name;
        //   $fp = fopen($file, "r");

        //   // 配列に変換する
        //   while (($data = fgetcsv($fp, 0, ", ")) !== FALSE)
        //   {
        //     $asins[] = $data;
        //   }
        //   fclose($fp);
        //   unlink('../data/'.$file_name);
        // } else {
        //   $err_msg = "ファイルをアップロードできません。";
        // }
      }
    } else {
      $err_msg = "ファイルが選択されていません。";
    }

    echo 'DBに接続したよresult.php</br>';
    echo $err_msg;
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }





//   $stmt = $PDO->prepare('INSERT INTO phpcsv ("name", "age", "gender") VALUES (?, ?, ?)');

// if (!$stmt):
//   die($PDO->error);
// endif;

// $stmt->bindValue('name', $name, PDO::PARAM_STR);
// $stmt->bindValue('age', $age, PDO::PARAM_INT);
// $stmt->bindValue('gender', $gender, PDO::PARAM_STR);

// $ret = $stmt->execute();

// if ($ret):
//   echo '登録されました';
// else:
//   echo $PDO->error;
// endif;

//       // $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR_CHAR);
//       // $stmt->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
//       // $stmt->bindValue(':gender', $_POST['gender'], PDO::PARAM_STR_CHAR);

//       // $sql = 'SELECT * FROM phpcsv';

//       // $stmt->execute();

//       // var_dump($stmt);
//       // // header('location: http://localhost:8001/');
//       // // exit();


// //   // home.phpの値を取得
// //   $name = $_POST['name'];
// //   $age = $_POST['age'];
// //   $gender = $_POST['gender'];
// //   var_dump($name);
// //   var_dump($age);
// //   var_dump($gender);
// //   // INSERT文を変数に格納。:名前や:年齢はプレースホルダという、値を入れるための単なる空箱
// //   $sql = 'INSERT INTO phpcsv ("名前", "年齢", ":性別") VALUES (?, ?, ?)';
// //   $stmt = $PDO->prepare($sql); // 挿入する値は空のまま、SQL実行の準備する
// //   $stmt->bindValue(':名前', $name, PDO::PARAM_STR);
// //   $stmt->bindValue(':年齢', $age, PDO::PARAM_INT);
// //   $stmt->bindValue(':性別', $gender, PDO::PARAM_STR);
// //   // $params = array(':名前' => $name, ':年齢' => $age, ':性別' => $gender);
// //   $stmt->execute(); // 挿入する値が入った変数をexecuteにセットしてSQLを実行





// // $stmt = $db->prepare('INSERT INTO phpcsv ("名前", "年齢", "性別") VALUES(?,?,?)');
// // if (!$db->error):
// //   die($db->error);
// // endif;

// // $stmt->bind_param($csvFile);
// // $ret = $stmt->execute();

// // if ($ret):
//   echo '登録されました。';
// else:
//   echo $db->error;
// endif;

// include ('../app/_parts/_header.php');
// var_dump($csvFile);
