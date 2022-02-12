<?php
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  try {
    $id = $_GET['id'];
    $sql ="SELECT * FROM users WHERE id = '".$id."'";
    $stmt =connect()->query($sql);

    if (empty($_GET['id'])) {
      header("Location: admin.php");
      exit;
    }

    // $_GET['id']を一行で取得する
    $form = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($form);





  } catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }

?>




  <form action="update_user.php" method="post">
    <dl>

      <dt>メールアドレス</dt>
      <dd>
          <input type="hidden" name="id" value="<?php echo h($form['id']); ?>">
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
    <div><input type="submit" value="更新する"/></div>
  </form>





<p><a href="admin.php">管理画面へ</a></p>


<!-- //     // フォームチェック
  //     $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  //     if ($form['email'] === '') {
  //       $error['email'] = 'blank';
  //     }
  
  
  //     $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  //     if ($form['password'] === '') {
  //       $error['password'] = 'blank';
  //     } elseif (strlen($form['password']) < 4) {
  //       $error['password'] = 'length';
  //     }
  
  
  // // エラーが起こっていないときの処理 $errorの中が空っぽのとき
  //     if (empty($error)) {
  //       header('Location: users_list.php');
  //       echo 'OKOK';
  //     } -->
