<?php
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  try {
    connect();
    $sql = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
    $stmt = connect()->prepare($sql);
    $update = array(':email' => $_POST['email'], ':password' => $_POST['password'], ':id' => $_POST['id']);
    $stmt->execute($update);
    header('Location: users_list.php');
    exit;

  } catch  (PDOException $e) {
    echo 'DB接続エラー:'.$e->getMessage();
  }


