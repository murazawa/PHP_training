<?php
ini_set('display_errors', "On");
// require ('../app/functions.php');
// require ('../app/validate.php');

  try
  {
    $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    // $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root'); // MAMP環境

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
            // var_dump($data);
            // var_dump($csv_data);
          }
          fclose($fp);
          
          $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
          $stmt = $PDO->prepare($sql);
          // $stmt->bindParam(1, $csv_data['id'], PDO::PARAM_INT);
          $stmt->bindParam(1, $csv_data['name'], PDO::PARAM_STR);
          $stmt->bindParam(2, $csv_data['age'], PDO::PARAM_INT);
          $stmt->bindParam(3, $csv_data['gender'], PDO::PARAM_STR, 3);
          var_dump($csv_data);
          $stmt->execute();
          
      }
    } else {
      $err_msg = "ファイルが選択されていません。";
    }

    // $sql = 'INSERT INTO phpcsv ("name", "age", "gender") VALUES (?, ?, ?)';
    // $stmt = $PDO->prepare($sql);
  

    // // var_dump($stmt);
    // $stmt->execute();


    echo 'DBに接続したよresult.php</br>';
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }
  
////////////////////////////////

