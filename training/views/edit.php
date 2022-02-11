<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php

ini_set('display_errors', "On");
include('../app/_parts/_header.php');
require('../app/functions.php');

try {

  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境


  $id = $_GET['id'];
  // $sql = 'SELECT * FROM phpcsv';
  $sql = "SELECT * FROM phpcsv WHERE id ='".$id."'";

  $stmt = $PDO->query($sql);
  // URLの？以降で渡されるIDをキャッチ


  // もし、$idが空であったらhome.phpにリダイレクト
  // 不正なアクセス対策
  if (empty($_GET['id'])) {
    header("Location: home.php");
    exit;
  }

  // 結果が一行で取得できたら
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // $id = $row['id'];
    $name = $row['name'];
    $age = $row['age'];
    $gender = $row['gender'];
  } else {
    // 対象のIDレコードがない => 不正な画面遷移
    echo '対象のデータがありません';
  }

} catch (PDOException $e) {
  echo 'エラーが発生しました。:' . $e->getMessage();
}
?>





<div class="modal"></div>
<div class="update">
  <form action="results.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    名前:</br>
    <input type="text" name="name" id="name" value="<?php echo $name; ?>"></br>
    年齢:</br>
    <input type="text" name="age" id="age" value="<?php echo $age; ?>"></br>
    性別</br>
    男<input type="radio" name="gender" id="gender" value="男" checked> | 
    女<input type="radio" name="gender" id="gender" value="女"></br>

    <input type="submit" value="更新">
  </form>
</div>
<!--



$stmt = $PDO->prepare('SELECT * FROM phpcsv WHERE id = :id');
  $params = array(':id' => $_GET["id"]);
  $stmt->execute($params);

  $result = 0;

  $result = $stmt->fetch(PDO::FETCH_ASSOC);






 -->
