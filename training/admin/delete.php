<?php
  ini_set('display_errors', "On");
  include('../app/_parts/_header.php');
  require_once('../connect.php');
  require('../app/functions.php');

  try {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = connect()->prepare($sql);
    $stmt->execute(array(':id' => $id));
    header('Location: users_list.php');
    exit;

  } catch (PDOExeption $e) {
    echo '失敗'.$e->getMessage();
  }
