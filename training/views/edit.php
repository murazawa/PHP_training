
<?php

try {

  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
  $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

  // URLの？以降で渡されるIDをキャッチ
  $id = $_GET['id'];

  // もし、$idが空であったらhome.phpにリダイレクト
  // 不正なアクセス対策
  if (empty($id)) {
    header("Location: home.php");
    exit;
  }

  // 結果が一行で取得できたら
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $name = $row['name'];
    $age = $row['age'];
    $gender = $row['gender'];
  } else {
    // 対象のIDレコードがない => 不正な画面遷移
    echo '対象のデータがありません';
  }




} catch (Exception $e) {
          echo 'エラーが発生しました。:' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>編集</title>

    <div class="contact-form">
        <h2>編集</h2>
        <form action="update.php" method="post">
                <input type="hidden" name="id" value="<?php echo(htmlspecialchars($result->id, ENT_QUOTES, 'UTF-8'));?>">
            <p>
                <label>お名前：</label>
                <input type="text" name="name" value="<?php if (!empty($result['name'])) echo(htmlspecialchars($result->name, ENT_QUOTES, 'UTF-8'));?>">
            </p>
            <p>
                <label>年齢：</label>
                <input type="text" name="age" value="<?php if (!empty($result['age'])) echo(htmlspecialchars($result->age, ENT_QUOTES, 'UTF-8'));?>">
            </p>

            <p>
                <label>性別：</label>
                <input type="text" name="gender" value="<?php if (!empty($result['gender'])) echo(htmlspecialchars($result->gender, ENT_QUOTES, 'UTF-8'));?>">
            </p>

            <input type="submit" value="編集する">

        </form>
    </div>
        <a href="home.php">投稿一覧へ</a>
</body>
</html>

<!--



$stmt = $PDO->prepare('SELECT * FROM phpcsv WHERE id = :id');
  $params = array(':id' => $_GET["id"]);
  $stmt->execute($params);

  $result = 0;

  $result = $stmt->fetch(PDO::FETCH_ASSOC);






 -->
