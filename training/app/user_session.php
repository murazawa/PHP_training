<?php

function sessionTime() {
  if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: login_form.php');
  }
  $_SESSION['start'] = time();
}

function sessionCheck() {
  if(isset($_SESSION['login_user']['email'])){
  echo $_SESSION['login_user']['email']." でログインしています";
  }else{
  header('Location:login_form.php');
  exit;
  }
}
