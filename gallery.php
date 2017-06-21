<?php
session_start();
include "config/connection.php";
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<a class='logout' href="logout.php">Logout</a>
<?php
if (isset($_SESSION['login']))
    echo "<a class='logout' href=\"camagru.php\">Camagru</a>";
$pid = $_GET['pid'];
$comment_info = array();
if ($_POST['submit'] == 'send' && !empty($_POST['msg']) && !empty($_SESSION['login'])) {
    $comment = "INSERT INTO `comments` (`cid`, `user_email`, `photo_id`, `comment`, `comment_time`) VALUES (NULL, '".$_SESSION['login']."', '".$pid."', '".$_POST['msg']."', CURRENT_TIMESTAMP)";
    mysql_query($comment);
    $receiver = mysql_query("SELECT user_email FROM photos WHERE pid='".$pid."'");
    $to = mysql_fetch_array($receiver);
    $subject = "New comment on your photo";
    $body = 'You receive a new comment on your photo(#'.$pid.'). Comment - '.$_SESSION['login'].': '.$_POST['msg'];
    mail($to['user_email'], $subject, $body);
}
$img = mysql_query("SELECT image, likes FROM photos WHERE pid='".$pid."'");
$img = mysql_fetch_array($img);
if (!empty($pid)) {
    echo "<div style='display: inline-block; float: right'>";
    echo "<img align='right' width='800px' height='600px' name=" . $pid . " src='" . $img['image'] . "'>";
    echo "<div>";
    echo "<iframe width='800px' height='400px' src='chat.php?pid=$pid'></iframe>";
    if (!empty($_SESSION['login'])) {
        echo "<form method='post'>
        <input id='msg' type='text' name='msg' value=''>
        <input id='comment' type='submit' name='submit' value='send'>
        <a class='logout' href='like.php?pid=$pid'>Likes: " . $img['likes'] . "</a>
        </form>";
    }
    else {
        echo "<form method='post'>
        <input id='msg' type='text' name='msg' value=''>
        <input id='comment' type='submit' name='submit' value='send' disabled>
        <a class='logout' href='#'>Likes: " . $img['likes'] . "</a>
        </form>";
    }
    echo "</div>";
    echo "</div>";
}
echo "<div><h2>Camagru gallery</h2></div>";
$max_num_of_photo = 0;
$db = array();
$info = mysql_query("SELECT * FROM photos ORDER BY `photo_time` DESC");
$_SESSION['number_of_photos'] = mysql_num_rows($info);
while ($data = mysql_fetch_array($info, MYSQL_ASSOC))
    array_push($db, $data);
$page = $_GET['page'];
$photo_db = array();
if ($page == 0)
    $page = 1;
$page *= 10;
$begin_list = $page - 10;
while ($begin_list < $page && !empty($db["$begin_list"])) {
    array_push($photo_db, $db["$begin_list"]);
    $begin_list++;
}
foreach ($photo_db as $value) {
    $pid = $value['pid'];
    $image = $value['image'];
    echo "<div class='gallery'>";
    echo "<a href='gallery.php?pid=$pid'><img width='300px' height='250px' name=".$pid." src='".$image."'></a>";
    echo "<div class='info'>";
    echo "<p align='center'>".$value['user_email']."</p>
          <p align='center'>".$value['photo_time']."</p>";
    echo "</div>";
    echo "</div>";
    if ($max_num_of_photo == 4) {
        $max_num_of_photo = 0;
        echo "<br>";
    }
    else
        $max_num_of_photo++;
}
?>
<br>
<div class="pagination">
    <?php
        $number_of_page = 1;
        $pages = $_SESSION['number_of_photos'] / 10;
        if ($_SESSION['number_of_photos'] % 10 != 0)
            $pages += 1;
        $pages = intval($pages);
        while ($pages != 0) {
            echo "<a href='gallery.php?page=$number_of_page'>".$number_of_page."</a>";
            $number_of_page++;
            $pages--;
        }
    ?>
</div>
</body>
</html>
