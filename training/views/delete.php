<h1>削除画面だよ</h1>
<?php
try {
  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

  $id = $_GET['id'];
  $sql = "SELECT * FROM phpcsv WHERE id ='".$id."'";
  $stmt = $PDO->query($sql);
  if (empty($_GET['id'])) {
    header("Location: home.php");
    exit;
  }
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $age = $row['age'];
    $gender = $row['gender'];

  } else {
    echo '対象のデータがアリません。';
  }

} catch (PDOExeption $e) {
  echo '失敗'.$e->getMessage();
}


?>

  <form action="results.php" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
  名前: <?php echo $name; ?></br>
  年齢: <?php echo $age; ?></br>
  性別: <?php echo $gender; ?></br>

  <button type="button" onclick="history.back()">いいえ</button> <button type="submit">はい</button>
</form>
