<?php
require_once("func/header.php");

session_start();
$e = "";
?>
<!DOCTYPE html>
<title>会員登録</title>

<body>

<div class="container">

  <h1>会員登録</h1>
  <div class="row">

  <form action="signup_done.php" method="post">
    <p style="color:red"><?php echo $e ?></p>
    <label>ログインID</label> <input type="text" name="userid"> <br>
    <label style="width:5em;">名前</label> <input type="text" name="name"> <br>
    <label>パスワード</label> <input type="password" name="password"> <br>
    <input type="submit" value="登録" class="btn btn-primary">
  </form>
  </div>
</div>

<div style="margin-top: 3em;">
<a href="login.php">ログインIDをお持ちの方はこちらから</a>
</div>
