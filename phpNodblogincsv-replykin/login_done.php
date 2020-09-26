<?php
require_once("func/header.php");

//ログインするための画面
$e = "";
$t = "";
session_start();

//ログイン済みかを確認
if (isset($_SESSION['id'])) {
	header('Location: top.php'); //ログインしていればtop.phpへリダイレクト
	exit;
}

//ログイン機能 認証
if (!empty($_POST['userid']) && !empty($_POST['password'])) {
	$userid = $_POST['userid'];
	$password = $_POST['password'];
	$user = fopen("csv/user.csv", "r");
	while ($line = fgets($user)) {
		$users = explode(",", $line);
		$ids[] = trim($users[1]);
		$passwords[] = $users[3];
	}
	fclose($user);
	if (! in_array($userid, $ids)) {
		$e = "ログイン失敗";
	}
	// ログイン認証
	$user = fopen("csv/user.csv", "r");
	while ($line = fgets($user)) {
		$users = explode(",", $line);
		// IDとパスワードで一致した場合
		if ($users[1] == $userid && trim($users[3]) == $password) {
			// ログイン成功とする
			$_SESSION['id'] = $users[0];
			$_SESSION['name'] = trim($users[2]);
			$t = "<a href='top.php' style = 'color:blue'>トップページへ</a>";
			break;
		}
	}
	if ($t == "") {
		// IDかパスワードが違う
		$e = "ログイン失敗";
	}
	fclose($user);
}

?>
<title>ログイン</title>

<?php if ($e) { ?>
<div class="alert alert-danger" role="alert"><?php echo $e; ?></div>
<meta http-equiv="refresh" content="1;URL=login.php">
<?php } ?>

<?php if ($t) { ?>
<div class="alert alert-primary" role="alert"><?php echo $t; ?></div>
<meta http-equiv="refresh" content="1;URL=top.php">
<?php } ?>

