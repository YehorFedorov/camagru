<?php
$host="localhost";
$user=""; // login for database
$pass=""; // password for database
$db_name="camagru";
$link=mysql_connect($host,$user,$pass);
mysql_select_db($db_name,$link);
?>