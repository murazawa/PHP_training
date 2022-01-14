<?php
  $test = 'hoge.csv';
  require('../app/functions.php');
  include('../app/_parts/_header.php');


?>
<p><?php checkFile($test); ?></p>