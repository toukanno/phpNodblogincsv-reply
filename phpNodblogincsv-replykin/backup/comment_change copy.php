<?php
require_once("func/header.php");

session_start();
// // // ログイン済みかを確認
if(!isset($_SESSION['id'])){
  header('Location: login.php');
  exit;
}
//postの値がからだったら送信できないようにもしたい
if (!empty($_POST['line_number'])) {
  $placeholder = "";
  $handle = fopen("csv/text.csv", "r");
  $line_number = 0;
  while ($line = fgets($handle)) {
    // 該当行の取得
    $line_number++;
    if ($line_number != $_POST['line_number']) continue;
    $lines = explode(",", $line);
    $placeholder = $lines[1];
    break;
  }
  fclose($handle);
}
?>

<title>コメント編集</title>
<body>

<div class="container">

  <h1>コメント編集</h1>

  <form action="comment_change_done.php" method="post">
    <input type="text" name="comment" value="<?php echo $placeholder; ?>">
    <input type="submit" value="保存" class="btn btn-primary">
    <input type="hidden" value="<?php echo $_POST['line_number']; ?>" name="line_number">
  </form>
</body>

</html>
