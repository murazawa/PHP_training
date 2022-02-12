<?php
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  $sql = 'SELECT * FROM users';
  $users = connect()->query($sql);
  echo "<h1>ユーザーリスト</h1>";
  echo '<table border="1">';
  echo '<tr>';
  echo '<th>メールアドレス</th>';
  echo '<th>パスワード</th>';
  echo '<th>作成日</th>';
  echo '<th>更新日</th>';
  echo '<th>編集</th>';
  echo '<th>削除</th>';
  echo '</tr>';

  foreach ($users as $user) {
    echo '<tr>';
    echo '<td>'.h($user['email']).'</td>';
    echo '<td>'.h($user['password']).'</td>';
    echo '<td>'.h($user['updated_at']).'</td>';
    echo '<td>'.h($user['created_at']).'</td>';
    echo '<td>'.'<a href=edit_user.php?id='.$user['id'].'>更新</a>'.'</td>';
    echo '<td>'.'<a href=delete_user.php?id='.$user['id'].'>削除</a>'.'</td>';
    echo '</tr>';
  }
  echo '</table>';
?>
<p><a href="admin.php">管理画面へ</a></p>
