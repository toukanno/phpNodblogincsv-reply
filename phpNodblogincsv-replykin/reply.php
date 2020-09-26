<?php
require_once("func/header.php");
session_start();
if (!$_SESSION['id']) {
  header('Location: login.php');
  exit;
}
if (!$_POST['textid']) {
  header('Location: login.php');
  exit;
}


print_r($_POST['textid']);
print_r($_POST['login_id']);
print_r($_SESSION['id']);
?>
<!DOCTYPE html>
<title>返信内容</title>

<body>
  <div class="container">
    <h1>返信内容</h1>
    <div class="row">
      <p class="bg-success"><?php echo $_POST['textid']."番目"; ?></ｐ><br>
      <p class="text-light bg-dark"><?php echo $_POST['login_id']."さんに返信する"; ?></ｐ><br>
      <p class="bg-info"><?php echo "内容:".$_POST['comment']; ?></p><br>
      <form action="reply_done.php" method="post">
        コメント<br>
        <input type="text" name="comment"><br>
        <input type="hidden" value="<?php echo $_POST['textid']; ?>" name="textid"><br>
        <input type="hidden" value="<?php echo $_POST['login_id']; ?>" name="login_id"><br>
        <input type="submit" value="投稿" class="btn  btn-outline-primary"><br>
      </form>
    </div>
  </div>
</body>