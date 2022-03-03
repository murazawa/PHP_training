<script src="../views/script.js"></script>

<?php
// session_start重要
  session_start();

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');

  require_once('../connect.php');
  require_once('../app/functions.php');
  require_once('../app/user_session.php');

  sessionTime();
  sessionCheck();


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


    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if (!preg_match("/\A[a-z\d]{4,34}+\z/i", $form['password'])) {
      $error['passeord'] = 'format';
    }




// エラーが起こっていないときの処理 $errorの中が空っぽのとき
    if (empty($error)) {
      $_SESSION['form'] = $form;
      header('Location: new.php');
    }
  }
?>
<script>
  try {
    function checkValue(v) {
      if(v.match(/[^0-9a-zA-Z]/)) {
        alert('半角英数字以外の文字が含まれています。');
        throw new Error('処理を終了');
      }
      console.log('この記述は実行されない');
    }
    // checkValue(v);

  } catch(e) {
    console.log(e.message);
  }

</script>



<form action="" method="post" enctype="multipart/form-data">
  <dl>

      <dt>メールアドレス</dt>
      <dd>
          <input type="email" name="email" size="35" maxlength="255" value="<?php echo h($form['email']); ?>"/>
          <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
            <p class="error">* メールアドレスを入力してください</p>
          <?php endif; ?>

      <dt>パスワード(4文字以上)</dt>
      <dd>
          <input type="text" name="password" id="password" size="10" maxlength="20" value=""/>
          <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
          <p class="error">* パスワードを入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
          <p class="error">* パスワードは4文字以上で入力してください</p>
          <?php endif; ?>
          <?php if (isset($error['password']) && $error['password'] === 'format'): ?>
          <p class="error">* 英数字で入力してください</p>
          <?php endif; ?>
      </dd>


  <div><input type="submit" onclick="checkValue(document.getElementById('password').value)" value="ユーザーを登録する"/></div>
</form>

