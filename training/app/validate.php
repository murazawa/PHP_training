<?php
  require ('..//results.php');
  function columnCheck() {
    if ($data[1] == "" || $data[2] == "")
    {
      exit ('名前、年齢は必須項目です。');
    }
  }