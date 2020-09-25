<?php
require_once("func/header.php");

session_start();
if (isset($_SESSION['id'])) {
  header('Location: top.php'); //ログインしていればtop.phpへリダイレクト
  exit;
}
?>
<title>ログイン</title>

<body>

  <div class="container">
    <div class="row">

      <div class="form_contents">
        <h2>ログイン</h2>

        <div style="text-align:right;"> <a href="signup.php">新規登録はこちらから</a> </div>

        <form action="login_done.php" method="post">

          <div>
            <span>ログインID</span>
            <input type="text" class="formbox" size="40" name="userid" placeholder="ログインID" required> 必須
          </div>

          <div>
            <span>パスワード</span>
            <input type="password" class="formbox" size="40" name="password" id="password" placeholder="パスワード" required> 必須
          </div>

          <div>
            <input type="submit" name='login' class="btn btn-primary" size="35" value="ログイン">
          </div>
        </form>

      </div>

    </div>
  </div>