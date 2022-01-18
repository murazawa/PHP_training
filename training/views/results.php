<?php
ini_set('display_errors', "On");
// require ('../app/functions.php');
// require ('../app/validate.php');

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
      }
    } else {
      $err_msg = "ファイルが選択されていません。";
    }

    echo 'DBに接続したよresult.php</br>';
    echo $err_msg;
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }

