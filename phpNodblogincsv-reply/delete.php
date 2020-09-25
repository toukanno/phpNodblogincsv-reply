<?php
require_once("func/header.php");

session_start();
?>

<title>退会処理</title>
<body>

  <h1>退会処理</h1>

  <a href="top.php">トップページ</a>

<div class="container">

  <form action="delete_done.php" method="post">
    <input type="submit" value="退会する" class="btn btn-danger">
  </form>
