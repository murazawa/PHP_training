<?php
  require ('../app/functions.php');
  require ('../app/validate.php');

  include ('../app/_parts/_header.php');


?>

<p>CSVをデータベースに登録します</p>

<form action="results.php" method="post">
  <p><input type="file" name="csv_file"/></p>
  <!-- <p><input type="file" name="csv_file"/></p> -->
  <!--hiddenあとで-->
  <p><button>アップロード</button></p>
</form>



<?php
  include('../app/_parts/_footer.php');
