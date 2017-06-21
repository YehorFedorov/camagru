<?php
session_start();
require_once "config/connection.php";
$pid = $_GET['pid'];
$comment_info = array();
$comment_table = mysql_query("SELECT comment, user_email, comment_time FROM comments WHERE photo_id='".$pid."'");
while ($data = mysql_fetch_array($comment_table, MYSQL_ASSOC))
    array_push($comment_info, $data);
foreach ($comment_info as $item) {
    echo "<p>".$item['comment_time']." ".$item['user_email'].": ".$item['comment']."</p>";
}