<?php
  include('../app/_parts/_header.php');

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $to = $_POST['email'];
  $subject = $_POST['subject'];
  $message = 'ががががががが<br/>ごごごごごごご';


  if(mb_send_mail($to, $subject, $message)){
    echo '<p>アップロードしたデータをメールでお送りました。</p>';
  } else {
    echo '<p>メールの送信に失敗しました。</p>';
  }




?>




<?php
  include('../app/_parts/_footer.php');