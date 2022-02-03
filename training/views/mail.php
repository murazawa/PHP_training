<?php
  include('../app/_parts/_header.php');
  ini_set('display_errors', "On");

  try
  {
    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境


//////////////////////////////////////////////////////////////////////////
///////////////////  DBからファイルに書き込み  ///////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////

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



    echo 'DBに接続したよ</br>';

  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }


//////////////////////////////////////////////////////////////////////////
///////////////////  メールファイル添付機能  /////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
  $to = $_POST['email']; // 宛先
  $subject = $_POST['subject']; // 件名
  $message = 'がががががが'."\r\n".'ごごごごごごご'; // 本文

  mb_language("ja");
  mb_internal_encoding("utf-8");

  $boundary = '----=_Boundary_' . uniqid(rand(1000,9999) . '_') . '_';
  $head = "From: 送信元メールアドレス\r\n";
  $head .= "MIME-Version: 1.0\n";
  $head .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\n";
  $head .= "\n";


////////////// 次するとき//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
//////////// https://qiita.com/P2eFR6RU/items/82c04966594a255de62a //////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////これ見る/////////////////////////////////////////////////

  $body = "--$boundary\n";
  $body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n";
  $body .= "\n";
  $body .= "$message\n";
  $body = "--$boundary\n";


  // text/plain	テキストファイル
  $handle = fopen($filename, 'r');
  $attachFile = fread($handle, filesize($filename));
  fclose($handle);
  $attachEncode = base64_encode($attachFile);



  $body .= "Content-Type: text/plain; name=\"$filename\"\n";
  $body .= "Content-Transfer-Encoding: base64\n";
  $body .= "Content-Disposition: attachment; filename=\"$filename\"\n";
  $body .= "\n";
  $body .= chunk_split($attachEncode) . "\n";
  $body .= "--{$boundary}\n";


  if(mb_send_mail($to, $subject, $body, $head)){
    echo '<p>アップロードしたデータをメールでお送りました。</p>';
  } else {
    echo '<p>メールの送信に失敗しました。</p>';
  }
  fclose($fp);
?>


<?php
  include('../app/_parts/_footer.php');
