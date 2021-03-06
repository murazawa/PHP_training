<?php
  session_start();
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');
  require('../app/user_session.php');

  sessionTime();
  sessionCheck();


  try {
    $id = $_GET['id'];
    $sql ="SELECT * FROM users WHERE id = '".$id."'";
    $stmt = connect()->query($sql);

    if (empty($_GET['id'])) {
      header("Location: admin.php");
      exit;
    }

    // $_GET['id']を一行で取得する
    if ($form = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $email = $form['email'];
      $password = $form['password'];
    }
    // var_dump($form);
      // フォームチェック
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
        header('Location: update_user.php');
      }


  } catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }

?>

  <form action="" method="post">
    <dl>

      <dt>メールアドレス</dt>
      <dd>
          <input type="hidden" name="id" value="<?php echo h($form['id']); ?>">
          <input type="text" name="email" size="35" maxlength="255" value="<?php echo h($email); ?>"/>
          <?php if (isset($form['email']) === ''): ?>
            <p class="error">* メールアドレスを入力してください</p>
          <?php endif; ?>
          <p class="error">* 指定されたメールアドレスはすでに登録されています</p>

      <dt>パスワード(4文字以上)</dt>
      <dd>
          <input type="password" name="password" size="10" maxlength="20" value="<?php echo h($password); ?>"/>
          <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
          <p class="error">* 4文字以上でパスワードを入力してください</p>
          <?php endif; ?>

      </dd>
    <div><input type="submit" value="更新する"/></div>
  </form>





<p><a href="admin.php">管理画面へ</a></p>


