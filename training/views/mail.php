<?php
  include('../app/_parts/_header.php');
  ini_set('display_errors', "On");

  try
  {
    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

    $filename = "sample_file.txt";
    $export_sql = 'SELECT * FROM phpcsv';

    $mail_stmt = $PDO->query($export_sql);
    $list = $mail_stmt->fetchAll(PDO::FETCH_ASSOC);


    $fp = fopen($filename, "w");


    // テキストファイルのヘッダー名の定義
    if (flock($fp, LOCK_EX)) {  //                      排他ロックを確保
      ftruncate($fp, 0);      //                        ファイルを切り詰めます
      fwrite($fp, "名前"." "."年齢"." "."性別"." "."\n"); // fwriteを使って書く
      fflush($fp);            //                        出力をフラッシュしてからロックを解放します
      flock($fp, LOCK_UN);    //                        ロックを解放します
    }


    foreach($list as $value){
      fwrite($fp, $value["name"]." ");
      fwrite($fp, $value["age"]." ");
      fwrite($fp, $value["gender"]." "."\n");
    }

    echo 'ファイルを更新しました';
    fclose($fp);



    echo 'DBに接続したよ</br>';

  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }



  exit;
  $to = $_POST['email']; // 宛先
  $subject = $_POST['subject']; // 件名
  $message = 'がががががが'."\r\n".'ごごごごごごご'; // 本文
  // $filename = 'テストabc.txt';


  mb_language("ja");
  mb_internal_encoding("utf-8");

  $mime_type = "application/octet-stream";
  $boundary = '----=_Boundary_' . uniqid(rand(1000,9999) . '_') . '_';
  // $head  = "From: " . mb_encode_mimeheader(mb_convert_encoding($from_name,"ISO-2022-JP")) . "<" . $from . "> \n";
  $head = "MIME-Version: 1.0\n";
  $head .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\n";
  $head .= "Content-Transfer-Encoding: 7bit";


  $body = "--{$boundary}\n";
  $body .= "Content-Type: text/plain; charset=ISO-2022-JP;" .
      "Content-Transfer-Encoding: 7bit\n";
  $body .= "\n";
  $body .= "{$message}\n";
  $body .= "\n";

  // text/plain	テキストファイル


  $filename = mb_convert_encoding($filename, 'ISO-2022-JP');
  $filename = "=?ISO-2022-JP?B?" . base64_encode($filename) . "?=";
  $body .= "--{$boundary}\n";
  $body .= "Content-Type: {$mime_type}; name=\"{$filename}\"\n" .
      "Content-Transfer-Encoding: base64\n" .
      "Content-Disposition: attachment; filename=\"{$filename}\"\n\n";
  // $f_encoded = chunk_split(base64_encode($filebody));
  // $body .= $f_encoded . "\n\n";


  if(mb_send_mail($to, $subject, $body, $head)){
    echo '<p>アップロードしたデータをメールでお送りました。</p>';
  } else {
    echo '<p>メールの送信に失敗しました。</p>';
  }

?>


<?php
  include('../app/_parts/_footer.php');
