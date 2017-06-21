<?php
session_status();
require_once "config/connection.php";
$user = $_SESSION['login'];
$pid_to_delete = $_GET['pid'];
mysql_query("DELETE FROM `photos` WHERE `photos`.`pid` = '".$pid_to_delete."'");
mysql_query("DELETE FROM `comments` WHERE `comments`.`photo_id` = '".$pid_to_delete."'");
header("Location: camagru.php");
?>