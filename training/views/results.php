<?php

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require('../app/functions.php');


  function csvData(){
  // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

    $result = 'SELECT * FROM phpcsv';
    $csv_stmt = $PDO->query($result);
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>名前</th>';
    echo '<th>年齢</th>';
    echo '<th>性別</th>';
    echo '<th>UPDATE</th>';
    echo '<th>DELETE</th>';

    echo '</tr>';
    foreach ($csv_stmt as $csvdata) {
      echo '<tr>';
      echo '<td>'.$csvdata['name'].'</td>';
      echo '<td>'.$csvdata['age'].'</td>';
      echo '<td>'.$csvdata['gender'].'</td>';
      echo '<td><a href=?id='.$csvdata['id'].'update'.'>更新</a></td>'; //GETでidを渡している
      echo '<td><a href=?id='.$csvdata['id'].'delete'.'>削除</a></td>';
      echo '</tr>';
    }
    echo '</table>';


    // メールフォーム //
    echo '<form action="mail.php" method="post">';

    // 宛先
    echo '<p><input type="email" name="email" placeholder="メールアドレスを入力してくだい"></p>';

    // 件名
    echo '<input type="hidden" name="subject" value="CSVファイル送付">';
    echo '<p><input type="submit" value="結果をメールで送信"></p>';

    echo '</form>';
    echo '<a href="home.php">アップロード画面へ</a> / ';
    echo '<a href="insert.php">インサート画面へ</a> / ';
    echo '<a id="scroll" href="javascript:topScroll()">≫</a>';

    exit;
}



  $url = $_SERVER['REQUEST_URI'];

  try {

    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境
  
    // URLにidがあればモーダルからupdate処理
    if(strstr($url,'update')) {

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
        echo '対象のデータがありません';
      }
    } elseif (strstr($url, 'delete')) {

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
    }

  } catch (PDOException $e) {
    echo 'エラーが発生しました。:' . $e->getMessage();
  }
?>
  <?php if(strstr($url,'update')): ?>
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
  <div class="csv"><?php csvData(); ?></div>

  <?php elseif(strstr($url, 'delete')): ?>
    <div class="update">
      <form action="results.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        名前: <?php echo $name; ?></br>
        年齢: <?php echo $age; ?></br>
        性別: <?php echo $gender; ?></br>
        <p>本当に削除しますか？</p>
        <button type="button" onclick="history.back()">いいえ</button> <button type="submit">はい</button>
      </form>
    </div>
    <div class="csv"><?php csvData(); ?></div>

  <?php endif; ?>



<?php
  $table = "";
  if (isset($_GET['table'])) {
    $table = csvData();
  }
?>



<?php

  try
  {

    // $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境
    $PDO = new PDO('mysql:dbname=myapp;host=localhost;charset=utf8','root', 'root'); // MAMP環境

    // トランザクション処理
    $PDO->beginTransaction();



    date_default_timezone_set('Asia/Tokyo');
    date_default_timezone_get();

    $done = '../done/';
    $error = '../error/';
    $path = date("Y-m-d H:i:s").'.csv';
    $err_msg= "";
    $log = 'logs.csv';
    $timestamp = date("Y-m-d H:i:s");

    if (!empty($_FILES["csvfile"]["tmp_name"]) && is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {



      if (pathinfo($_FILES["csvfile"]["name"], PATHINFO_EXTENSION) != 'csv') {
        move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列方式拡張子失敗_'.$path);
        $a = fopen($log, "a");
        fwrite($a, $timestamp." "."Warning:CSVファイルではない". " "."指定したファイルはCSVファイルではありません"."\n");
        fclose($a);
        exit ('選択ファイルには、CSVタイプのファイルを指定してください。');
      }


      $fp = fopen($_FILES["csvfile"]["tmp_name"], "r");
      $flag = true;
      while (($data = fgetcsv($fp)) !== FALSE)
      {
        if ($data[1] == "" || $data[2] == "") {
          move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列正式名前、年齢失敗_'.$path);
          $a = fopen($log, "a");
          fwrite($a, $timestamp." "."Error:３列正式名前、年齢誤り". " "."年齢、性別に誤りがあります"."\n");
          fclose($a);
          exit ('名前、年齢は必須項目です。');
        }
        if (isset($data[4])) {
          move_uploaded_file($_FILES["csvfile"]["tmp_name"], $error.'３列正式フォーマット失敗_'.$path);
          $a = fopen($log, "a");
          fwrite($a, $timestamp." "."Error:３列正式フォーマット誤り". " "."フォーマットに誤りがあります"."\n");
          fclose($a);
          exit ('正しいフォーマットで入力してください。');
        }


        if($flag) { $flag = false; continue; }

        $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(1, $data[1], PDO::PARAM_STR);
        $stmt->bindParam(2, $data[2], PDO::PARAM_STR);
        $stmt->bindParam(3, $data[3], PDO::PARAM_STR);
        $stmt->execute();
      } // while 閉じ
      fclose($fp);


      if (move_uploaded_file($_FILES["csvfile"]["tmp_name"], $done.'３列正式_'.$path)) { // $done.'３列正式.csv'  ３列正式.csvという名前に変更して保存
        $a = fopen($log, "a");
        fwrite($a, $timestamp." "."Success:".$_FILES["csvfile"]["name"]." "."指定したCSVファイルをデータベースに登録しました"."\n");
        fclose($a);

        echo 'アップロードに成功しました。</br>';
      } else {
        echo '失敗.....';
      }
    } else {


/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// 次, 結果表示ボタンを展開した状態でアップロードからのデータがある時と無いときで処理を分ける
 if (empty($_POST['id'])) {

  if (!isset($_POST['age']) || $_POST['age'] === ""){
    echo '送信内容をもう一度ご確認ください。';
    $PDO->commit();
    csvData();
  }


  if (!isset($_POST['name']) || $_POST['name'] === ""){
    echo '送信内容をもう一度ご確認ください。';
    $PDO->commit();
    csvData();
  }

  $sql = 'INSERT INTO phpcsv (name, age, gender) VALUES (?, ?, ?)';
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(1, $_POST['name'], PDO::PARAM_STR);
  $stmt->bindParam(2, $_POST['age'], PDO::PARAM_STR);
  $stmt->bindParam(3, $_POST['gender'], PDO::PARAM_STR);
  $stmt->execute();

  echo '追加したよ';
  $PDO->commit();
  csvData();




} else {
      $sql = 'UPDATE phpcsv SET name = :name, age = :age, gender = :gender WHERE id = :id';
      $stmt = $PDO->prepare($sql);

      if (empty($_POST['name'])) {

        $sql = 'DELETE FROM phpcsv WHERE id = :id';
        $stmt = $PDO->prepare($sql);
        $stmt->execute(array(':id' => $_POST['id']));
        echo '削除したよ';
        $PDO->commit();
        csvData();
      }
      $params = array(':name' => $_POST['name'], ':age' => $_POST['age'], ':gender' => $_POST['gender'], ':id' => $_POST['id']);
      $stmt->execute($params);
      echo 'データが更新されました';

      $PDO->commit();


      csvData();
    }

  }
    $PDO->commit();
  } catch  (PDOException $e) {
    $PDO->rollback();
    echo 'DB接続エラー:'.$e->getMessage();
  }
?>

<p>結果表示ボタンを押下して内容をご確認ください。</p>
<form action="" method="get">
  <p><input type="submit" name="table" value="結果を表示"/></p>
  <!--hiddenあとで-->
</form>
<a href="home.php">アップロード画面へ</a>
<a href="insert.php">インサート画面へ</a>
<?php
  include('../app/_parts/_footer.php');

// 参考 アップデート
// https://www.flatflag.nir87.com/update-950
// https://freeks-japan.blog/php/4/12/
