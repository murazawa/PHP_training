<?php
  include('../app/_parts/_header.php');
  ini_set('display_errors', "On");


  $to = $_POST['email']; // 宛先
  $subject = $_POST['subject']; // 件名
  $message = 'がががががが'."\r\n".'ごごごごごごご'; // 本文
  $filename = 'テスト.txt';


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
