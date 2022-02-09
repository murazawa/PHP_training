<?php

  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require('../app/functions.php');
  createToken();

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    validateToken();
  }
?>


<h1>インサート画面だよ</h1>

<form action="results.php" method="post">
  <input type="hidden" name="token" value="<? h($_SESSION['token']); ?>">
  名前:</br>
  <input type="text" name="name" id="name" value=""></br>
  年齢:</br>
  <input type="text" name="age" id="age" value=""></br>
  性別</br>
  男<input type="radio" name="gender" id="gender" value="男" checked> | 
  女<input type="radio" name="gender" id="gender" value="女"></br>

  <input type="submit" value="データを追加">
</form>
<a href="home.php">アップロード画面へ</a>
