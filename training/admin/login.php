<?php
  session_start();

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');




  $result = false;
  if (isset($_SESSION['form'])) {
    $login_form = $_SESSION['form'];
    $password = $login_form['password'];

  } else {
    header('Location: admin.php');
    exit;
  }

  try {
  $sql = "SELECT * FROM users WHERE email = ?";

  $array = [];
  $array[] = $login_form['email'];

  $stmt = connect()->prepare($sql);
  $stmt->execute($array);
  $user = $stmt->fetch();
  if (password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['login_user'] = $user;
    $result = true;
    echo 'ログイン成功';

  } else {
    echo 'ログイン失敗';
  }


} catch (PDOException $e) {
  echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

