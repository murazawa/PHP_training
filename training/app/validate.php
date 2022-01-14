<?php

  function checkFile($filename){
    // 拡張子チェック
    if(preg_match('/.csv/', $filename)){
      echo 'データをアップロードしました。</br>';
    } else {
      echo '選択したファイルはCSVではありません。<br/>';
    }
  }

  function csvPost() {
    if (isset(($_POST['csv_file'])))
    {
      checkFile($_POST['csv_file']);

      // $csvFile = $_POST['csv_file'];
      // echo $csvFile.' 成功しました';
    }
  }