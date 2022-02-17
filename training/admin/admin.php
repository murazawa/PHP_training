<?php
  session_start();
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
?>
<h1>ユーザー管理画面</h1>
<?php if (isset($_SESSION['msg']) !== ""): ?>
  <?php echo $_SESSION['msg']; ?>
<?php endif; ?>

<p><a href="create_user.php">ユーザー新規登録へ</a></p>
<p><a href="users_list.php">ユーザーリストへ</a></p>

<p><a href="login_form.php">ログインフォームへ</a></p>



・ログイン状態はsessionを用いて30分間保持し，ログイン中ならログインフォーム画面から自動的に管理画面に遷移するものとする。
２．ログアウト機能
・ログインsessionを削除してログインフォーム画面に戻る
