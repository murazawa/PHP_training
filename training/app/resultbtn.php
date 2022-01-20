<?php function csvData() {
  $PDO = new PDO('mysql:host=localhost;dbname=myapp;charset=utf8','root'); // XAMPP環境

  $result = 'SELECT * FROM phpcsv';
  $csv_stmt = $PDO->query($result); ?>

  <table border="1">
    <tr>
      <th>名前</th>
      <th>年齢</th>
      <th>性別</th>
    </tr>
    <?php foreach ($csv_stmt as $csvdata): ?>
    <tr>
      <td><?php echo $csvdata['name']; ?></td>
      <td><?php echo $csvdata['age']; ?></td>
      <td><?php echo $csvdata['gender']; ?></td>
    </tr>
    <?php endforeach; ?>
  </table>

<?php } ?>
<button onclick="clickResult()"> 結果を表示 </button>
<script>
  function clickResult() {
    var result = "<?php csvData(); ?>"
    document.write(result);
  }
</script>
