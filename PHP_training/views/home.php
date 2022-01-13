<?php
  require('../app/functions.php');
  include('../app/_parts/_header.php');

?>

<p>CSVをデータベースに登録します</p>

<form action="#" method="post">
  <p><input type="file" name="csv"/></p>
  <!--hiddenあとで-->
  <p><button>アップロード</button></p>
</form>




<?php
  include('../app/_parts/_footer.php');