<?php
session_start();
require_once("func/header.php");
if (!$_SESSION['id']) {
	header('Location: login.php');
	exit;
}
if (!$_POST['comment']) {
	header('Location: top.php');
	exit;
}
//postの値がからだったら送信できないようにもしたい
// 読み込み
// print_r($_POST['flg']);
if (!empty($_POST['comment'])) {
	$handle = fopen("csv/text.csv", "r");
	$data = "";
	while ($line = fgets($handle)) {
		$data .= $line;
	}
	// 投稿
	$textid = file("csv/textid.csv");
	$textid[0] +=1;
	$textids =fopen("csv/textids.csv","a");
	fwrite($textids,$textid[0]."\n");
	fclose($textids);
	$line = $textid[0];
	$line .= "," . $_POST['flg']; //最初の投稿
	$line .= "," . $_SESSION['id'];
	$line .= "," . $_POST["comment"];
	$line .= "," . date('Y-m-d H:m:s');
	$line .= "," . 0; //削除フラグ
	$line .= PHP_EOL;
	$data .= $line;
	fclose($handle);

	// 書き込み
	$handle = fopen("csv/text.csv", "w");
	fwrite($handle, $data);
	fclose($handle);
}
$textidfp = fopen("csv/textid.csv", "w");
		fwrite($textidfp, $textid[0]);
		fclose($textidfp);
?>
<meta http-equiv="refresh" content="1;URL=top.php">
コメントを投稿しました。