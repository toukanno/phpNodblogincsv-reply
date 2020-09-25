<?php
session_start();
require_once("func/header.php");
if (!$_SESSION['id']) {
	header('Location: login.php');
	exit;
}
if (!$_POST['textid']) {
	header('Location: login.php');
	exit;
}
print_r($_POST['textid']);
print_r($_POST['login_id']);
print_r($_SESSION['id']);
// ユーザからの情報があるかないかの確認
function getUserText($textid)
{
	$handle = fopen("csv/text.csv", "r");
	while ($line = fgets($handle)) {
		$column = explode(",", $line);
		if ($textid != trim($column[0])) {
			continue;
		}
		$user["textid"] = trim($column[0]);
		$user["textflg"] = trim($column[1]);
		$user["id"] = trim($column[2]);
		$user["name"] = trim($column[3]);
		$user["date"] = trim($column[4]);
		$user["deleteflg"] = trim($column[5]);
		return $user;
	}
	return false;
}
$user = getUserText($_POST['textid']);

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
	$line .= "," . $_POST['textid']; //最初の投稿かへんしんかどうか
	$line .= "," . $_SESSION['id'];
	$line .= "," . $_POST['textid'] . "番目の" . $_POST['login_id'] . "へ返信：" . $_POST["comment"];
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
コメントを投稿しました