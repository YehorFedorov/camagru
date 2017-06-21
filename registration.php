<?php
    session_start();
    include "config/connection.php";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form action="registration.php" method="post">
<div id = "reg_window">
    <div><h2>Registration</h2></div>
    <div class="log_pass">
        <input class="form_auth" placeholder="Enter your e-mail here..." type="text" name="login" value="<?php
            if (!empty($_POST['login'])) {
                if (!filter_var($_POST['login'], FILTER_VALIDATE_EMAIL)) 
                    $_POST['mailErr'] = 'Invalid e-mail format';
                else {
                    $_SESSION['login'] = mysql_real_escape_string($_POST['login']);
                    $_POST['mailErr'] = 'Success';
                }
            }
        ?>
">
    </div>
    <?php
    if (!empty($_POST['mailErr']) && $_POST['mailErr'] !== 'Success')
        echo "<a id ='error'>".$_POST['mailErr']."</a>";
    ?>
    <br>
    <div class="log_pass">
        <input class="form_auth" type="password" name="passwd" placeholder="Enter password here..." value="<?php
        if(!empty($_POST["passwd"])) {
            $password = $_POST["passwd"];
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
        elseif (!empty($_POST['passwd'])) {
            $_SESSION['passwd'] = hash('whirlpool', mysql_real_escape_string($_POST['passwd']));
            $_POST['re-passwdErr'] = 'Success';
        }
?>
">
    </div>
    <?php
        if (!empty($_POST['re-passwdErr']) && $_POST['re-passwdErr'] !== 'Success')
            echo "<a id ='error'>".$_POST['re-passwdErr']."</a>";
        if ($_POST['mailErr'] === 'Success' && $_POST['passwdErr'] === 'Success' && $_POST['re-passwdErr'] === 'Success') {
            $flag = 0;
            $users = array();
            $logins = mysql_query("SELECT email FROM users");
            while ($login = mysql_fetch_array($logins, MYSQL_ASSOC))
                array_push($users, $login);
            foreach ($users as $value) {
                if (strtolower($value['email']) === strtolower($_POST['login']))
                        $flag = 1;
            }
            if (!$flag) {
                $db = mysql_query("INSERT INTO `users` (`uid`, `email`, `password`, `active`, `reg_time`) VALUES (NULL, '".$_SESSION['login']."', '".$_SESSION['passwd']."', '0', CURRENT_TIMESTAMP)");
                require_once "mail.php";
                echo "<br><a id = 'success'>Success! Check your email for the confirmation link</a>";
                header("Refresh: 2.4; url=index.php");
            }
            else {
                echo "<br><a id = 'error'>Sorry, user with this email already registered. If you forgot your password you can press 'Forgot password' on main page.</a>";
            }
        }
        elseif (empty($_POST['mailErr']) && $_POST['passwdErr'] === 'Success' && $_POST['re-passwdErr'] === 'Success')
            echo "<br><a id = 'error'>Please fill in all fields of this form</a>";
    ?>
    <div>
        <input id = "button" type="submit" name="submit" value="Register">
        <a id = "button_main" href="index.php">Back to log in</a>
    </div>
</div>
</form>
</body>
</html>