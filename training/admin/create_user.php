<?php
// session_start重要
  session_start();

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  // noticeやWarningは初期化やissetである程度解決できる
  // 配列の値を初期化
  $form = [
    'email' => '',
    'password' => ''
  ];
  $error = [];

  connect();
  // フォーム内容のチェック
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($form['email'] === '') {
      $error['email'] = 'blank';
    }


    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($form['password'] === '') {
      $error['password'] = 'blank';
    } elseif (strlen($form['password']) < 4) {
      $error['password'] = 'length';
    }


// エラーが起こっていないときの処理 $errorの中が空っぽのとき
    if (empty($error)) {
      $_SESSION['form'] = $form;
      header('Location: new.php');
      exit ('ユーザーの新規登録に失敗しました');
    }
  }



?>
<form action="" method="post" enctype="multipart/form-data">
  <dl>

      <dt>メールアドレス</dt>
      <dd>
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($form['email']); ?>"/>
          <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
          <?php endif; ?>
          <p class="error">* 指定されたメールアドレスはすでに登録されています</p>

      <dt>パスワード(4文字以上)</dt>
      <dd>
          <input type="password" name="password" size="10" maxlength="20" value=""/>
          <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
          <p class="error">* パスワードを入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
          <p class="error">* パスワードは4文字以上で入力してください</p>
          <?php endif; ?>
      </dd>
  <div><input type="submit" value="ユーザーを登録する"/></div>
</form>

