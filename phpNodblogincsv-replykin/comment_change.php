<?php
require_once("func/header.php");

session_start();
// // // ログイン済みかを確認
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}
//テキストidが空だったらログインphpへ戻す
if (!$_POST['textid']) {
  header('Location: login.php');
  exit;
}
$placeholder = "";
$handle = fopen("csv/text.csv", "r");

while ($line = fgets($handle)) {
  // 該当行の取得
  $lines = explode(",", $line);
  if ($lines[0] != $_POST['textid']) continue;
  $placeholder = $lines[3];
  break;
}
fclose($handle);

?>

<title>コメント編集</title>

<body>

  <div class="container">

    <h1>コメント編集</h1>

    <form action="comment_change_done.php" method="post">
      <input type="text" name="comment" value="<?php echo $placeholder; ?>">
      <input type="submit" value="保存" class="btn btn-primary">
      <input type="hidden" value="<?php echo $_POST['textid']; ?>" name="textid">
    </form>
</body>

</html>