<?php

  session_start();
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require('../app/user_session.php');
  require_once('../connect.php');


  sessionTime();
  sessionCheck();

?>


<h1>ユーザー管理画面</h1>

<p><a href="create_user.php">ユーザー新規登録へ</a></p>
<p><a href="users_list.php">ユーザーリストへ</a></p>
<p><a href="logout.php">ログアウトする</a></p>
<p><a href="../views/home.php">CSVアップロード画面</a></p>
