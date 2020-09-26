<?php
session_start();
require_once("func/header.php");
$t = "";
if (!isset($_SESSION['id'])) {
	header('Location: login.php');
	exit;
}
if (!isset($_POST['line_number'])) {
	header('Location: login.php');
	exit;
}

// 読み込み
$handle = fopen("csv/text.csv", "r");
$line_number = 0;
$data = "";
while ($line = fgets($handle)) {
	$line_number++;
	if ($_POST["line_number"] == $line_number) {
		// 削除フラグとして先頭に-をつけることとした
		$line = "-" . $line;
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
