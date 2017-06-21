<?php
session_start();
include "config/connection.php";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<form method="post">
<div id = "login_window">
    <div><h2>Camagru</h2></div>
        <div class="log_pass">
            <input class="form_auth" placeholder="e-mail" type="text" name="login" value="">
        </div>
    <br>
    <div class="log_pass">
        <input class="form_auth" type="password" name="passwd" placeholder="password" value="">
    </div>
    <?php
    if (!empty($_POST['login'])) {
        $login = mysql_real_escape_string($_POST['login']);
        $passwd = mysql_real_escape_string($_POST['passwd']);
        $result = mysql_query("SELECT * FROM users WHERE email='" . $login . "' and password = '" . hash('whirlpool',$passwd) . "'");
        $count = mysql_num_rows($result);
        $result = mysql_fetch_array($result);
        if ($count == 0)
            echo "<a id = 'error'>Wrong login or password!</a>";
        else {
            if ($result['active'] == 1) {
                $_SESSION['login'] = $login;
                header('Location: camagru.php');
            }
            else
                echo "<br><a id = 'error'>Your account isn't authorized yet. Check your email for confirmation link</a>";
        }
    }
    ?>
    <br>
        <div>
        <input id = "button" type="submit" name="submit" value="Sign in">
        </div>
    <a id = "registration" href="registration.php">Create new account</a>
    <a id = "forgot_pass" href="new_pass.php">Forgot your password?</a>
</div>
</form>
<?php
echo "<div><h2>Camagru gallery</h2></div>";
$max_num_of_photo = 0;
$db = array();
$info = mysql_query("SELECT * FROM photos");
while ($data = mysql_fetch_array($info, MYSQL_ASSOC))
    array_push($db, $data);
foreach ($db as $value) {
    $pid = $value['pid'];
    $image = $value['image'];
    echo "<div class='gallery'>";
    echo "<a href='gallery.php?pid=$pid'><img width='300px' height='250px' name=" . $pid . " src='" . $image . "'></a>";
    echo "<div class='info'>";
    echo "<p>" . $value['user_email'] . "</p>
            <p>" . $value['photo_time'] . "</p>";
    echo "</div>";
    echo "</div>";
    if ($max_num_of_photo == 4) {
        $max_num_of_photo = 0;
        echo "<br>";
    } else
        $max_num_of_photo++;
}
?>
</body>
</html>
