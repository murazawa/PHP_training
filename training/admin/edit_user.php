<?php
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  try {
    $id = $_GET['id'];
    $sql


  } catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }

?>




<table>
  <tr>
    <th>メールアドレス</th>
    <th>パスワード</th>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>

</table>





<p><a href="admin.php">管理画面へ</a></p>
