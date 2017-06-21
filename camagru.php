<?php
session_start();
if (isset($_SESSION['login']))
{
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="capture.js"></script>
</head>
<body>

<header>
    <a class="logout" href="gallery.php">Gallery</a>
    <?php
        echo "<h1 style='float: right'>Hello, ".$_SESSION['login']."</h1>";
        echo "<a class='logout' href=\"logout.php\">Logout</a>";
    ?>
</header>
<br>
<main>
    <div id = "main_frame">
        <form action="" method="post">
            <div id = "images">
                <input class="radio" id = "cat" type="radio" value="cat" name="img" onclick="isradio(id)">
                <img class="img" src="img/cat.png"><br>
                <input class="radio" id = "tree" type="radio" value="tree" name="img" onclick="isradio(id)">
                <img class="img"src="img/tree.png"><br>
                <input class="radio" id = "spider" type="radio" value="spider" name="img" onclick="isradio(id)">
                <img class="img" src="img/spider.png"><br>
                <input class="radio" id = "monkey" type="radio" value="monkey" name="img" onclick="isradio(id)">
                <img class="img" src="img/monkey.png"><br><br>
                <input class="radio" id = "kappa" type="radio" value="kappa" name="img" onclick="isradio(id)">
                <img class="img" src="img/kappa.png"><br>
            </div>
        </form>
        <div class="user_gallery">
            <?php
            require_once "config/connection.php";
            $photos = array();
            $max_num_of_photo = 0;
            $photo_request = mysql_query("SELECT image, pid FROM photos WHERE user_email='".$_SESSION['login']."' ORDER BY `photo_time` DESC");
            $_SESSION['user_photos'] = mysql_num_rows($photo_request);
            while ($data = mysql_fetch_array($photo_request))
                array_push($photos, $data);
            $page = $_GET['page'];
            $photo_db = array();
            if ($page == 0)
                $page = 1;
            $page *= 9;
            $begin_list = $page - 9;
            while ($begin_list < $page && !empty($photos["$begin_list"])) {
                array_push($photo_db, $photos["$begin_list"]);
                $begin_list++;
            }
            foreach ($photo_db as $value) {
                $pid = $value['pid'];
                echo "<img width='300px' height='250px' name=" . $pid . " src='" . $value['image'] . "'>";
                echo "<a class='delete' href='delete.php?pid=$pid'>X</a>";
                if ($max_num_of_photo == 2) {
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
                $pages = $_SESSION['user_photos'] / 9;
                if ($_SESSION['user_photos'] % 9 != 0)
                    $pages += 1;
                $pages = intval($pages);
                while ($pages != 0) {
                    echo "<a href='camagru.php?page=$number_of_page'>".$number_of_page."</a>";
                    $number_of_page++;
                    $pages--;
                }
                ?>
            </div>
        </div>
            <div class="camera">
            <video id="video">Video stream isn't allowed on your computer:(</video>
            <button id="startbutton" disabled>Take photo</button>
            <canvas id="canvas">
            </canvas>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>
            <?php
                $file = $_SESSION['login'].".png";
                if (file_exists($file))
                    echo "<img src='$file'>";
            ?>
        </div>
    </div>
</main>
<br>
<footer>
<div>
    <hr>
    <h4>©efedorov 2017</h4>
</div>
</footer>
<script>
    function isradio(id) {
        document.body.img_name = id;
        document.getElementById('startbutton').disabled = false;
    }
</script>
</body>
</html>
<?php
}
else
    header("Location: index.php");
?>