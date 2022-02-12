<?php

  session_start();
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');
  
  // session_start重要
// connect();
  

  if (isset($_SESSION['form'])) {
    $form = $_SESSION['form'];
    var_dump($form);

  } else {
    header('Location: admin.php');
    exit('不正なアクセスがありました。');
  }


  try {
    connect(); // DB接続

    if (!$PDO) {
      die($PDO->error);
    }

    $sql = 'INSERT INTO users (email, password) VALUES(?, ?)';
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(1, $_SESSION['form']['email'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_SESSION['form']['password'], PDO::PARAM_STR);
    $stmt->execute();


    echo 'DBに追加したよ';


  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>


<p>メールアドレス：<?php echo h($form['email']); ?><p>
<p>パスワード：<?php echo h($form['password']); ?></p>

<?php

  $sql = 'SELECT * FROM users';
  $users = $PDO->query($sql);
  echo '<table border="1">';
  echo '<tr>';
  echo '<th>メールアドレス</th>';
  echo '<th>パスワード</th>';
  echo '<th>作成日</th>';
  echo '<th>更新日</th>';
  echo '</tr>';

  foreach ($users as $user) {
    echo '<tr>';
    echo '<td>'.$user['email'].'</td>';
    echo '<td>'.$user['password'].'</td>';
    echo '<td>'.$user['updated_at'].'</td>';
    echo '<td>'.$user['created_at'].'</td>';

    // echo '<td>'.'<a class="edit_modal" href=edit.php?id='.$user['id'].'>更新</a>'.'</td>';
    // echo '<td>'.'<a href=delete.php?id='.$user['id'].'>削除</a>'.'</td>';
    echo '</tr>';
  }
  echo '</table>';
?>
