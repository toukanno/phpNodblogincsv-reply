<?php
session_start();
require_once("func/header.php");
$t = "";
if (!isset($_SESSION['id'])) {
	header('Location: login.php');
	exit;
}
if (!isset($_POST['textid'])) {
	header('Location: top.php');
	exit;
}

// 読み込み
$handle = fopen("csv/text.csv", "r");
$data = "";
while ($line = fgets($handle)) {
	$lines = explode(",", $line);
	if ($_POST['textid'] == $lines[0]) {
		// 削除フラグとして行末に1をつけることとした
		$line = $lines[0];
		$line .= "," . trim($lines[1]); //最初の普通の投稿かもしくは返信内容か？
		$line .= "," . $_SESSION['id'];
		$line .= "," . $_POST["comment"];
		$line .= "," . date('Y-m-d H:m:s');
		$line .= "," . 1; //削除フラグ
		$line .= PHP_EOL;
	}
	//postでわたってきたidとflgidを比較して一致したものを通す
	if($_POST['textid'] == $lines[1]) {
		$line = $lines[0];
		$line .= "," . trim($lines[1]); //最初の普通の投稿かもしくは返信内容か？textflg
		$line .= "," . trim($lines[2]); //userid
		$line .= "," . trim($lines[3]); //comment
		$line .= "," . date('Y-m-d H:m:s'); //時間
		$line .= "," . 1; //削除フラグをつける
		$line .= PHP_EOL;
	}
	$data .= $line;
}
print_r($data);
fclose($handle);

// 書き込み
$handle = fopen("csv/text.csv", "w");
fwrite($handle, $data);
fclose($handle);

?>
<meta http-equiv="refresh" content="1;URL=top.php">
コメントを削除しました。