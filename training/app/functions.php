<?php

function h($string) {
  return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}



function createToken() {
  if ( !isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}

function validateToken() {
  if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
    exit('おっとっと');
  }
}
