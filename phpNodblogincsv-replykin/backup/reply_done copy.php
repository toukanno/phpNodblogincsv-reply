<?php
session_start();
require_once("func/header.php");
$e = "";
$t1 = "";
$t2 = "";
if (!$_SESSION['id']) {
	header('Location: login.php');
	exit;
}
if (!$_POST['line_number']) {
	header('Location: login.php');
	exit;
}
print_r($_POST['line_number']);
print_r($_POST['login_id']);
print_r($_SESSION['id']);
// ユーザからの情報があるかないかの確認
if (!empty($_POST['login_id']) && !empty($_POST['comment']) && !empty($_POST['line_number'])) {
	$handle = fopen("csv/text.csv", "r");
	$line_number = 0;
	$data = "";
	while ($line = fgets($handle)) {
		$line_number++;
		$data .= $line;
	}
	// 投稿
	$line = $_SESSION['id'];
	$line .= "," . $_POST['line_number'] . "番目の" . $_POST['login_id'] . "へ返信：" . $_POST["comment"];
	$line .= "," . date('Y-m-d H:m:s');
	$line .= PHP_EOL;
	$data .= $line;
	fclose($handle);

	// 書き込み
	$handle = fopen("csv/text.csv", "w");
	fwrite($handle, $data);
	fclose($handle);
	

	$t1 = "投稿が完了しました。";
	$t2 = "<a href='top.php'>トップページへ</a>";
} else {
	$e = "入力が空です。";
	$e .= '<script> setTimeout("window.history.back()", 2000); </script>';
}


?>
<title>返信内容 確認</title>

<body>

	<?php if ($e) { ?>
		<div class="alert alert-danger" role="alert"><?php echo $e; ?></div>
		<?php die(); ?>
	<?php } ?>

	<?php if ($t1) { ?>
		<div class="alert alert-primary" role="alert"><?php echo $t1; ?></div>
	<?php } ?>

	<h2>返信内容 確認</h2>
	<p>以下内容で投稿しました。</p>
	<div> <label style="width:5em;">コメント</label> : <?php echo $_POST['comment']; ?> </div>
	<?php if ($t2) { ?>
		<?php echo $t2; ?>
	<?php } ?>