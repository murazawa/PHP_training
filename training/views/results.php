<?php
ini_set('display_errors', "On");

  try
  {
    // require ('../app/functions.php');
    // require ('../app/validate.php');
    include('../app/_parts/_header.php');
    $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    // $PDO = new PDO('mysql:host=localhost:8889;dbname=myapp;charset=utf8','root','root'); // MAMP環境
    $err_msg= "";

    if (!empty($_FILES["csvfile"]["tmp_name"]))
    {
      $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
      $file_name = $_FILES["csvfile"]["name"];
      

      if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv')
      {
        /// 拡張子チェック //////////////
        $err_msg = '選択ファイルには、CSVタイプのファイルを指定してください。';
        ///////////////////////////////
      } else {

          $fp = fopen($file_tmp_name, "r");

          $flag = true;
          while (($data = fgetcsv($fp)) !== FALSE)
          
          {
            // var_dump($data);
            /// キーチェック ///////////
            if (isset($data[1]) == "" || isset($data[2]) == "")
            { 
              die('名前、年齢は必須項目です。');
              // 何もなかったことにする
              // case?使う
            }
            //////////////////////////
            
            /// フォーマットチェック ///
            if (isset($data[4]))
            {
              $err_msg = '正しいフォーマットで入力してください。';
            }
            //////////////////////////
              if($flag) { $flag = false; continue; }

              $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
              $stmt = $PDO->prepare($sql);
              $stmt->bindParam(1, $data[1], PDO::PARAM_STR);
              $stmt->bindParam(2, $data[2], PDO::PARAM_STR);
              $stmt->bindParam(3, $data[3], PDO::PARAM_STR);
              $stmt->execute();
          }

          fclose($fp);          
      }
    } else {
      $err_msg = 'ファイルを選択してください。';
    }

    echo $err_msg;
    echo 'DBに接続したよresult.php</br>';
  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }