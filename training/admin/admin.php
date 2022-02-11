<?php

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');

  $form = [];
  $error = [];

  $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
  if ($form['email'] === '') {
    $error['email'] = 'blank';
  }


?>
<h1>ユーザー管理画面</h1>
<p>ユーザー新規登録</p>
<p>ユーザーリスト</p>
<p>ユーザー編集画面</p>
<p>ユーザー削除画面</p>


<form action="" method="post" enctype="multipart/form-data">
  <dl>

      <dt>メールアドレス</dt>
      <dd>
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo $form['email']; ?>"/>
          <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
            <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
          <?php endif; ?>
      <dt>パスワード</dt>
      <dd>
          <input type="password" name="password" size="10" maxlength="20" value=""/>
          <p class="error">* パスワードを入力してください</p>
          <p class="error">* パスワードは4文字以上で入力してください</p>
      </dd>
  <div><input type="submit" value="ユーザーを登録する"/></div>
</form>
