<?php
session_start();
$_SESSION = array();
session_destroy();

header("Location:login.php");
//ログアウト処理
// public static function logout(){
//   $_SESSION = array();
//   session_destroy();
// }

?>