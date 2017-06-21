<?php
session_start();
require_once "config/connection.php";
print_r($_GET);
$pid = $_GET['pid'];
print_r($_SESSION);
if (!empty($pid) && !empty($_SESSION['login']))
    mysql_query("UPDATE `photos` SET `likes`=`likes` + 1 WHERE `photos`.`pid`='".$pid."'");
header("Location: gallery.php?pid=$pid");
?>