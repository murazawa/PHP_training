<?php
  include('../app/_parts/_header.php');
  ini_set('display_errors', "On");
  $file = 'テスト.txt';

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
  $headers = "From: info@gamil.jp"; // ヘッダー設定
  $to = $_POST['email']; // 宛先
  $subject = $_POST['subject']; // 件名
  $message = 'がががががが'."\r\n".'ごごごごごごご'; // 本文
	$message .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\r\n\r\n";

	// ファイルを添付
	$message .= "Content-Type: application/octet-stream; name=\"{$file}\"\r\n";
	$message .= "Content-Disposition: attachment; filename=\"{$file}\"\r\n";
	$message .= "Content-Transfer-Encoding: base64\r\n";
	$message .= "\r\n";
	$message .= chunk_split(file_get_contents($file));
	// $message .= "--__BOUNDARY__--";



 




  if(mb_send_mail($to, $subject, $message, $headers, $addheader)){
    echo '<p>アップロードしたデータをメールでお送りました。</p>';
  } else {
    echo '<p>メールの送信に失敗しました。</p>';
  }

?>


<?php
  include('../app/_parts/_footer.php');
