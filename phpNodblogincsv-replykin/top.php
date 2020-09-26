<?php
require_once("func/header.php");

session_start();

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

// function getUserText($flg)
// {
// 	$handle = fopen("csv/text.csv", "r");
// 	while ($line = fgets($handle)) {
// 		$column = explode(",", $line);
// 		if ($flg > 0) {
// 			continue;
// 		}
// 		$user2["textid"] = trim($column[0]);
// 		$user2["textflg"] = trim($column[1]);
// 		$user2["id"] = trim($column[2]);
// 		$user2["comment"] = trim($column[3]);
// 		$user2["date"] = trim($column[4]);
// 		$user2["deleteflg"] = trim($column[5]);
// 		$value[] = $user2;
// 		return $user2;
// 	}
// 	return false;
// }

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
			$handle = fopen("csv/text.csv", "r");
			while ($line = fgets($handle)) {
				$lines = explode(",", $line);
				$a[] = $lines;
				// $textids[] = $lines[0];
				// $textflgs[] = trim($lines[1]);
			}
			$b = array();
			foreach ($a as $key => $value1) {
				if ($value1[1] == 0) {
					$b[] = $value1;
					// $e[] = $value1;
					// print_r($value1[2]);
					foreach ($a as $key2 => $value2) {

						if ($value1[0] == $value2[1]) {
							$b[] = $value2;
							// $c[] = $value2;
						}
					}
				}
			}
			// print_r($e);
			// $sorted_ary[] = $b;
			$a = $b;
			// print_r($a);

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
			// $delete = array();//削除されたtextIDを保存する用の配列
			foreach ($a as $key3 => $value3) {
				// 削除したコメントは非表示にする。1が削除されたコメント。
				// $delete = array();
				if (preg_match("/1.$/", $value3[5])) {
					// $delete[] = $value3[0]; //削除されたtextIDを保存する
					continue;
				}
				//返信フラグに削除フラグがついた内容があったら消える
				// if (in_array($value3[1], (array)$delete)) {
				// 	continue;
				// }

				$id = $value3[2];
				$login_id = "-";
				$name = "-";
				if (getLoginUser($id)) {
					$login_id = getLoginUser($id)["login_id"];
					$name = getLoginUser($id)["name"];
				}
				$textid = "-";
				$textflg = "-";
				$textid = $value3[0];
				$textflg = $value3[1];
				$comment = $value3[3];
				$datetime = $value3[4];
				$deleteflg = $value3[5];
				// $value = array($textid, $textflg, $id, $name, $date, $deleteflg, $comment, $datetime);

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

			?>
		</div>
	</div>
</body>