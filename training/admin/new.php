<?php

  session_start();
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');




  if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
    // var_dump($form);

  } else {
    header('Location: admin.php');
    exit('不正なアクセスがありました。');
  }


  try {

    if (!connect()) {
      die(connect()->error);
    }

    $sql = 'INSERT INTO users (email, password) VALUES(?, ?)';
    $stmt = connect()->prepare($sql);
    $stmt->bindParam(1, $_SESSION['form']['email'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_SESSION['form']['password'], PDO::PARAM_STR);
    $stmt->execute();


    echo '<p>ユーザーを追加しました。</p>';


  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>


<p>メールアドレス：<?php echo h($form['email']); ?><p>
<p>パスワード：<?php echo h($form['password']); ?></p>

<p><a href="admin.php">管理画面へ</a></p>

