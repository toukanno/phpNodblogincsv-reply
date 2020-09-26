<?php
session_start();
if (!$_SESSION['id']) {
	header('Location: login.php');
	exit;
}
if (!$_POST['textid']) {
	header('Location: top.php');
	exit;
}
//postの値がからだったら送信できないようにもしたい
//この場合だとすべての投稿が削除されてしまう
// 読み込み
if (!empty($_POST['comment'])) {
	$handle = fopen("csv/text.csv", "r");
	$data = "";
	while ($line = fgets($handle)) {
		$lines = explode(",", $line);
		if ($_POST['textid'] == $lines[0]) {
			// 編集
			$line = $lines[0];
			$line .= "," . trim($lines[1]); //最初の投稿か返信かどうか？
			$line .= "," . $_SESSION['id'];
			$line .= "," . $_POST["comment"];
			$line .= "," . date('Y-m-d H:m:s');
			$line .= "," . 0; //削除フラグ
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