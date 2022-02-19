<?php

  session_start();
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');
  require('../app/user_session.php');

  sessionTime();
  sessionCheck();



  if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
    // var_dump($form['password']);
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


    // パスワード暗号化
    $password = password_hash($form['password'], PASSWORD_DEFAULT);
    $stmt->bindParam(1, $_SESSION['form']['email'], PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);
    $stmt->execute();


    unset($_SESSION['form']);
    echo '<p>ユーザーを追加しました。</p>';


  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>


<p>メールアドレス：<?php echo h($form['email']); ?><p>
<p>パスワード：<?php echo h($form['password']); ?></p>

<p><a href="admin.php">管理画面へ</a></p>

