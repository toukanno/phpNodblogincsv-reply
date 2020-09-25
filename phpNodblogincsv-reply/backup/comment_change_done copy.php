<?php
session_start();
if (!$_SESSION['id']) {
	header('Location: login.php');
	exit;
}
if (!$_POST['line_number']) {
	header('Location: login.php');
	exit;
}
//postの値がからだったら送信できないようにもしたい
//この場合だとすべての投稿が削除されてしまう
// 読み込み
if (!empty($_POST['comment'])) {
	$handle = fopen("csv/text.csv", "r");
	$line_number = 0;
	$data = "";
	while ($line = fgets($handle)) {
		$line_number++;
		if ($_POST["line_number"] == $line_number) {
			// 編集
			$line = $_SESSION['id'];
			$line .= "," . $_POST["comment"];
			$line .= "," . date('Y-m-d H:m:s');
			$line .= PHP_EOL;
		}
		$data .= $line;
	}
	fclose($handle);
}

// 書き込み
$handle = fopen("csv/text.csv", "w");
fwrite($handle, $data);
fclose($handle);

?>
<meta http-equiv="refresh" content="1;URL=top.php">
コメントを変更しました。