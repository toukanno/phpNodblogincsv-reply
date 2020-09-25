<?php
require_once("func/header.php");

$e = "";
$t = "";
session_start();
if (!isset($_SESSION['id'])) {
  header('Location: login.php'); 
  exit;
}

$user = fopen("csv/user.csv", "r");
$value = array();
$userid = "";
$name = "";
$password = "";
while ($line = fgets($user)) {
	$users = explode(",", $line);
	if ($_SESSION['id'] == $users[0]) {
		$userid = trim($users[1]);
		$name = trim($users[2]);
		$password = trim($users[3]);
	}
}

if (!empty($_POST['userid2']) && !empty($_POST['name2']) && !empty($_POST['password2'])) {
	$id = $_SESSION['id'];
	$userid = $_POST['userid2'];
	$name = $_POST['name2'];
	$password = $_POST['password2'];
	$user = fopen("csv/user.csv", "r");
	$value = array();
	while ($line = fgets($user)) {
		$lines = explode(",", $line);
		if ($lines[0] != $id && trim($lines[1]) == $userid) {

			$e = "IDがすでに使われています";
		}
		if ($lines[0] != $id && trim($line[1]) != $userid) {
			$value[] = $line;
		}

		if ($lines[0] == $id) {
			$textcontent = implode(",", array($id, $userid, $name, $password . "\n"));
			$value[] = $textcontent;
		}
	}
	fclose($user);

	// エラーがなければ保存
	if ($e == "") {
		$handle = fopen("csv/user.csv", "w");

		foreach ($value as $val) {
			fwrite($handle, $val);
		}
		fclose($handle);
		$_SESSION['name'] = $name;
		$t = "内容を編集しました";
	}
}


?>
<title>ユーザー編集</title>

<body>
<div class="container">

  <h1><?php echo $_SESSION['name'] . "さんのユーザー編集画面"; ?></h1>

  <?php if ($e) { ?>
  <div class="alert alert-danger" role="alert"><?php echo $e; ?></div>
  <?php } ?>

  <?php if ($t) { ?>
  <div class="alert alert-primary" role="alert"><?php echo $t; ?></div>
  <?php } ?>

  <div style="text-align:center;">
	  <a href="top.php">[トップページ]</a>
	  <a href="delete.php" style="margin-left:6em;">[退会処理]</a>
  </div>

  <form action="edit.php" method="post">
    ログインID <input type="text" name="userid2" value="<?php echo $userid; ?>"> <br>
    ユーザー名 <input type="text" name="name2" value="<?php echo $name; ?>"> <br>
    パスワード <input type="password" name="password2" value="<?php echo $password ?>"> <br>
    <input type="submit" value="保存" class="btn btn-primary"> 
  </form>

</div>
