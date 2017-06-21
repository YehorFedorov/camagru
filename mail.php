<?php
require_once "config/connection.php";
$to = $_SESSION['login'];
$uid = mysql_query("SELECT uid FROM users WHERE email='".$to."'");
$id = mysql_fetch_array($uid);
$subject = "New User Validation";
$body = 'Click here to validate your account http://localhost:8080/camagru/activate.php?hash='.md5($id['uid'] + 42);
mail($to, $subject, $body);
?>