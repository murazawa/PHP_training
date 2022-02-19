<?php

  session_start();

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  if (isset($_SESSION['login_user']['email'])) {
    header('Location: admin.php');
  } else {
    echo 'ログアウトしました。';
  }




  $login_form = [
    'email' => '',
    'password' => ''
  ];
  $error = [];


  // POSTで受け取っているか確認
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login_form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($login_form['email'] === '') {
      $error['login'] = 'blank';
    }

    $login_form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($login_form['password'] === '') {
      $error['password'] = 'blank';
    } elseif (strlen($login_form['password']) < 4) {
      $error['password'] = 'length';
    }

    if (empty($error)) {
      $_SESSION['form'] = $login_form;
      header('Location: login.php');
      exit;
    }
  }



?>

<h1>ログインフォーム画面</h1>
<form action="" method="post" enctype="multipart/form-data">
  <dl>
  <?php if (isset($error['login']) && $error['login'] === 'blank'): ?>
    <p>正しいパスワードとメールアドレスをご記入ください</p>
  <?php endif; ?>
  <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
    <p class="error">パスワードを入力してください</p>
  <?php endif; ?>
  <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
    <p class="error">パスワードは4文字以上で入力してください</p>
  <?php endif; ?>
    <dt>メールアドレス</dt>
    <dd><input type="email" name="email" size="35" maxlength="255" value="<?php echo h($login_form['email']); ?>" ></dd>
  </dl>
  <dl>
    <dt>パスワード</dt>
    <dd>
      <input type="password" name="password" value="<?php echo h($login_form['password']); ?>">
  </dd>
  </dl>
  <input type="submit" value="ログインする">

</form>
