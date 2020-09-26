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
	$a[] = $lines;
}
// $b = array();
foreach ($a as $key => $value) {
	if ($_POST['textid'] == $value[0]) {
		// 削除フラグとして行末に1をつけることとした
		$line = $value[0];
		$line .= "," . $value[1]; //最初の普通の投稿かもしくは返信内容か？
		$line .= "," . $_SESSION['id'];
		$line .= "," . $_POST["comment"];
		$line .= "," . date('Y-m-d H:m:s');
		$line .= "," . 1; //削除フラグ
		$line .= PHP_EOL;
	}
	$data .= $line;
	foreach ($a as $key2 => $value2) {
		if ($value[0] == $value2[1]) {
			echo "test";
			// $b[] = $value2;
			$line = $value[0];
			$line .= "," . $value[1]; //最初の普通の投稿かもしくは返信内容か？
			$line .= "," . $value[2];
			$line .= "," . $_POST["comment"];
			$line .= "," . date('Y-m-d H:m:s');
			$line .= "," . 1; //削除フラグ
			$line .= PHP_EOL;
		}
	}
	$data .= $line;
}
fclose($handle);

// 書き込み
$handle = fopen("csv/text.csv", "w");
fwrite($handle, $data);
fclose($handle);

?>
<meta http-equiv="refresh" content="1;URL=top.php">
コメントを削除しました。