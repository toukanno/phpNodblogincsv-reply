<?php
require_once("func/header.php");

session_start();
$t = "";

if (!isset($_POST['destroy'])) {
	$user = fopen("csv/user.csv", "r");
	$value = array();
	$value2 = array();
	while ($line = fgets($user)) {
		$users = explode(",", $line);
		if ($_SESSION['id'] != $users[0]) {
			$value[] = $line;
			// break;
		} else {
			$value2[] = $line;
		}
	}
	fclose($user);
	$user = fopen("csv/user.csv", "w");
	foreach ($value as $val) {
		fwrite($user, $val);
	}
	fclose($user);
	$t = "アカウントを削除しました";
	session_destroy();
}
?>

  <?php if ($t) { ?>
  <div class="alert alert-primary" role="alert"><?php echo $t; ?></div>
  <?php } ?>

  <meta http-equiv="refresh" content="1;URL=top.php">
