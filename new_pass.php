<?php
include "config/connection.php";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form method="post" action="new_pass.php">
<div id = "reg_window">
    <div><h3>Forgot your password?</h3></div>
    <div class="log_pass">
        <input class="form_auth" placeholder="e-mail" type="text" name="login" value="">
    </div>
    <?php
    if ($_POST['submit'] != NULL && $_POST['login'] != NULL) {
        $flag = 0;
        $users = array();
        $logins = mysql_query("SELECT email FROM users");
        while ($login = mysql_fetch_array($logins, MYSQL_ASSOC))
            array_push($users, $login);
        foreach ($users as $value) {
            if (strtolower($value['email']) === strtolower($_POST['login']))
                $flag = 1;
        }
        if ($flag) {
            $to = mysql_real_escape_string($_POST['login']);
            $uid = mysql_query("SELECT uid FROM users WHERE email='".$to."'");
            $id = mysql_fetch_array($uid);
            $subject = "New User Validation";
            $body = "Click here to change your account password http://localhost:8080/camagru/reset.php?hash=".md5($id['uid'] + 42);
            mail($to, $subject, $body);
            echo "<a id ='success'> Success! Check your email!</a>";
        }
        else
            echo "<a id ='error'>Wrong email!</a>";
    }
    ?>
    <br>
    <div>
        <input id = "button_reset" type="submit" name="submit" value="Send me reset password instructions">
        <a id = "button_main" href="index.php">Back to log in</a>
    </div>
</div>
</form>
</body>
</html>