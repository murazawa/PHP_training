<?php
  include('../app/_parts/_header.php');
  ini_set('display_errors', "On");

  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  $to = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $headers = "From: info@gamil.jp";
  if(mb_send_mail($to, $subject, $message, $headers)){
    echo '<p>アップロードしたデータをメールでお送りました。</p>';
  } else {
    echo '<p>メールの送信に失敗しました。</p>';
  }




?>


<?php
if(mb_send_mail('mura.hi0115ki@gmail.com', 'メール送信テストタイトル', 'メール送信テスト：本文')) {
    echo "送信完了";
} else {
    echo "送信失敗";
}
?>

<?php
  include('../app/_parts/_footer.php');