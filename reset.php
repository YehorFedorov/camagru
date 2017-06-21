<?php
include "config/connection.php";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form method="post">
<div id = "reg_window">
    <br>
    <div class="log_pass">
        <input class="form_auth" type="password" name="passwd" placeholder="Enter password here..." value="<?php
        if(!empty($_POST["passwd"])) {
            $password = mysql_real_escape_string($_POST["passwd"]);
            if (strlen($_POST["passwd"]) < '8') {
                $_POST['passwdErr'] = "Your Password Must Contain At Least 8 Characters!";
            } elseif (!preg_match("#[0-9]+#", $password)) {
                $_POST['passwdErr'] = "Your Password Must Contain At Least 1 Number!";
            } elseif (!preg_match("#[A-Z]+#", $password)) {
                $_POST['passwdErr'] = "Your Password Must Contain At Least 1 Capital Letter!";
            } elseif (!preg_match("#[a-z]+#", $password)) {
                $_POST['passwdErr'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
            } else
                $_POST['passwdErr'] = 'Success';
        }
        ?>
">
    </div>
    <?php
    if (!empty($_POST['passwdErr']) && $_POST['passwdErr'] !== 'Success')
        echo "<a id ='error'>".$_POST['passwdErr']."</a>";
    ?>
    <br>
    <div class="log_pass">
        <input class="form_auth" type="password" name="re-passwd" placeholder="Re-enter password here..." value="<?php
        if ($_POST['re-passwd'] !== $_POST['passwd'])
            $_POST['re-passwdErr'] = 'Passwords do not match:(';
        elseif (!empty($_POST['passwd']))
            $_POST['re-passwdErr'] = 'Success';
        ?>
">
    </div>
    <?php
    if (!empty($_POST['re-passwdErr']) && $_POST['re-passwdErr'] !== 'Success')
        echo "<a id ='error'>".$_POST['re-passwdErr']."</a>";
    if ($_POST['passwdErr'] === 'Success' && $_POST['re-passwdErr'] === 'Success') {
        $password = mysql_real_escape_string($_POST['passwd']);
        $user = mysql_query("SELECT * FROM users WHERE md5(42 + uid)='".$_GET['hash']."'");
        $login = mysql_fetch_array($user);
        mysql_query("UPDATE `users` SET `password` ='".hash('whirlpool', $password)."'  WHERE `users`.`email` ='".$login['email']."'");
        echo "<br><a id = 'success'>Success! Your password has been changed</a>";
        header("Refresh: 3; url=index.php");
    }
    ?>
    <br>
    <div>
        <input id = "button_reset" type="submit" name="submit" value="Reset password">
        <a id = "button_main" href="index.php">Back to log in</a>
    </div>
</div>
</form>
</body>
</html>