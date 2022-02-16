<?php
  session_start();

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  // $error = [];
  // $email = '';
  // $password ='';

  // if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  //   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  //   $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  // }
  // if ($email === '' || $password === '') {
  //   $error['login'] = 'blank';
  // } else {
  //   // ログインチェック
  //   $DB = connect();
  //   $sql = 'SELECT * FROM users WHERE email = :email';
  //   $stmt = $DB->prepare($sql);
  //   if (!$stmt) {
  //     die($DB->error);
  //   }
    // var_dump($_POST['email']);
    // echo $email;
    echo $_SESSION['form']['email'];



    // $stmt->bindVale(':email', $email);
    // $stmt->execute();

    // $users = fetch();
    // if (password_verity($_POST['password']))
    // var_dump($hash);



    // // $stmt->execute();
    // // $stmt->bind_result($id, $email, $hash);
    // // $stmt->fetch();

    // var_dump($hash);
    // // echo 'OK';

  // }

?>

ログインしたよ
