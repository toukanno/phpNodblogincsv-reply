<?php
require_once("func/header.php");

//ログインしたメンバーのみがアクセスできる初期画面
//ここでtext.csvユーザ情報を編集させる
session_start();
// // // ログイン済みかを確認
if (!isset($_SESSION['id'])) {
	header('Location: login.php');
	exit;
}


function getLoginUser($session_id)
{
	$handle = fopen("csv/user.csv", "r");
	while ($line = fgets($handle)) {
		$column = explode(",", $line);
		if ($session_id != $column[0]) {
			continue;
		}
		$user["id"] = trim($column[0]);
		$user["login_id"] = trim($column[1]);
		$user["name"] = trim($column[2]);
		return $user;
	}
	return false;
}
$user = getLoginUser($_SESSION['id']);

// function getUserText()
// {
// 	$handle = fopen("csv/text.csv", "r");
// 	while ($line = fgets($handle)) {
// 		$column = explode(",", $line);
// 		$user2["textid"] = trim($column[0]);
// 		$user2["textflg"] = trim($column[1]);
// 		$user2["id"] = trim($column[2]);
// 		$user2["name"] = trim($column[3]);
// 		$user2["date"] = trim($column[4]);
// 		$user2["deleteflg"] = trim($column[5]);
// 		$value[] = $user2;
// 		return $user2;

// 	}
// 	return false;
// }
// $user2 = getUserText();

?>
<title>テキストテーブル</title>
<body>
	<div class="container">
		<h1>トップページ</h1>
		<div style="text-align:right;">
			<?php echo $_SESSION['name'] ?>さんでログイン中
			<a href="edit.php">[ユーザー情報編集]</a>
			<a href="logout.php">[ログアウト]</a>
		</div>
		<div class="row">
			<form action="comment_insert_done.php" method="post">
				コメント
				<input type="text" name="comment">
				<input type="hidden" name="flg" value="0">
				<input type="submit" value="投稿" class="btn btn-primary">
			</form>
		</div>

		<div class="row">
			<?php
			//読み取り専用でファイルを開く
			$handle = fopen("csv/text.csv", "r");

			//  テーブルのHTMLを生成
			echo "<table class='table'>
  <thead class='thead-light'>
    <tr>
    <th>番号</th>
    <th>ログインID</th>
    <th>ユーザー名</th>
    <th>コメント</th>
    <th>投稿日</th>
    <th></th>
		<th></th>
		<th></th>
    </tr>
  </thead>
  ";

			//  csvのデータを配列に変換し、HTMLに埋め込んでいる
			//fgetで値を一行ずつ取得する

			// 主キー UPDATE / DELETE用
			// $textid = 0;

			// 自分自身のCSVの内容を表示
		
			while ($line = fgets($handle)) {

				// 削除したコメントは非表示にする。1が削除されたコメント。
				if (preg_match("/1.$/", $line)) {
					continue;
				}

				// $linesっていう配列にexplodeでカンマ区切りを指定して　$lineを区切って代入する
				$lines = explode(",", $line);
				if ($lines[0] == trim($lines[1])) {
				}
				// if (1 == trim($lines[5])) {
				// 	continue;
				// }

				$id = $lines[2];
				$login_id = "-";
				$name = "-";
				if (getLoginUser($id)) {
					$login_id = getLoginUser($id)["login_id"];
					$name = getLoginUser($id)["name"];
				}
				$textid = $lines[0];
				$textflg = trim($lines[1]);
				$comment = trim($lines[3]);
				$datetime = trim($lines[4]);

				echo "<tr>";
				echo "<td>" . $textid . "</td>";
				echo "<td>" . $login_id . "</td>";
				echo "<td>" . $name . "</td>";
				echo "<td>" . $comment . "</td>";
				echo "<td>" . $datetime . "</td>";

				echo '<td>';
				if ($id == $_SESSION["id"]) {
					echo '<form action="comment_change.php" method="post">';
					echo '  <input type="hidden" value="' . $textid . '" name= "textid">';
					echo '  <input type="submit" class="btn btn-success" value="変更" >';
					echo "</form>";
				}
				echo "</td>";

				echo '<td>';
				if ($id == $_SESSION["id"]) {
					echo '<form action="comment_delete_done.php" method="post" onClick="return confirm(\'削除しますか？\');">';
					echo '  <input type="hidden" value = "' . $textid . '" name= "textid">';
					echo '  <input type="hidden" value = "' . $textflg . '" name= "textflg">';
					echo '  <input type="hidden" value = "' . $comment . '" name= "comment">';
					echo '  <input type="hidden" value = "' . $login_id . '" name= "login_id">';
					echo '  <input type="submit" class="btn btn-danger" value="削除" >';
					echo "</form>";
				}
				echo "</td>";

				echo '<td>';
				echo '<form action="reply.php" method="post" onClick="return confirm(\'返信しますか？\');">';
				echo '  <input type="hidden" value = "' . $textid . '" name= "textid">';
				echo '  <input type="hidden" value = "' . $textflg . '" name= "textflg">';
				echo '  <input type="hidden" value = "' . $login_id . '" name= "login_id">';
				echo '  <input type="hidden" value = "' . $comment . '" name= "comment">';
				echo '  <input type="submit" class="btn  btn-secondary" value="返信" >';
				echo "</form>";
				echo "</td>";

				echo "</tr>";
			}
			echo "</table>";


			// #4 ファイルを閉じる
			fclose($handle);
			?>
		</div>
	</div>
</body>