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
			$line_number = 0;

			// 自分自身のCSVの内容を表示
			while ($line = fgets($handle)) {
				$line_number++;
				// 削除したコメントは非表示にする。-から始まるものが削除されたコメント。
				if (preg_match("/^-/", $line)) {
					continue;
				}
				// $linesっていう配列にexplodeでカンマ区切りを指定して　$lineを区切って代入する
				$lines = explode(",", $line);

				$id = $lines[0];
				$login_id = "-";
				$name = "-";
				if (getLoginUser($id)) {
					$login_id = getLoginUser($id)["login_id"];
					$name = getLoginUser($id)["name"];
				}
				$comment = $lines[1];
				$datetime = $lines[2];

				echo "<tr>";
				echo "<td>" . $line_number . "</td>";
				echo "<td>" . $login_id . "</td>";
				echo "<td>" . $name . "</td>";
				echo "<td>" . $comment . "</td>";
				echo "<td>" . $datetime . "</td>";

				echo '<td>';
				if ($id == $_SESSION["id"]) {
					echo '<form action="comment_change.php" method="post">';
					echo '  <input type="hidden" value="' . $line_number . '" name= "line_number">';
					echo '  <input type="submit" class="btn btn-success" value="変更" >';
					echo "</form>";
				}
				echo "</td>";

				echo '<td>';
				if ($id == $_SESSION["id"]) {
					echo '<form action="comment_delete_done.php" method="post" onClick="return confirm(\'削除しますか？\');">';
					echo '  <input type="hidden" value = "' . $line_number . '" name= "line_number">';
					echo '  <input type="submit" class="btn btn-danger" value="削除" >';
					echo "</form>";
				}
				echo "</td>";

				echo '<td>';
				echo '<form action="reply.php" method="post" onClick="return confirm(\'返信しますか？\');">';
				echo '  <input type="hidden" value = "' . $line_number . '" name= "line_number">';
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