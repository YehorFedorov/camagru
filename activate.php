<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
require_once "config/connection.php";
$id = $_GET['hash'];
$user = mysql_query("SELECT * FROM users WHERE md5(42 + uid)='".$id."'");
$login = mysql_fetch_array($user);
if ($login['active'] == 0) {
    mysql_query("UPDATE `users` SET `active` ='1' WHERE `users`.`email` ='".$login['email']."'");
    echo "<h6>Success! Your account successfully activated!</h6>";
    header("Refresh: 1; url=index.php");
}
else {
    echo "<h6>Your account already activated!</h6>";
    header("Refresh: 1; url=index.php");
}
?>
</body>
</html>
