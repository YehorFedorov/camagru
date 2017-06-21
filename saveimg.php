<?php
session_start();
require_once "config/connection.php";
    $info = $_POST['radio'];
    $upload_photo = $_SESSION['login'].".png";
    if (file_exists($upload_photo)) {
        $data = file_get_contents($upload_photo);
        $data = 'data:image/png;base64,'.base64_encode($data);
        unlink($upload_photo);
    }
    else {
        $data = $_POST['image'];
    }
    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
    file_put_contents("photo.png", $data);

    $image_1 = imagecreatefrompng('photo.png');
    $image_2 = imagecreatefrompng('img/'.$info.'.png');
    imagealphablending($image_1, true);
    imagesavealpha($image_1, true);
    imagecopy($image_1, $image_2, 0, 0, 0, 0, 190, 190);
    imagepng($image_1, 'merged_photo.png');

    $merge = file_get_contents('merged_photo.png');
    $data = 'data:image/png;base64,' . base64_encode($merge);
    unlink("merged_photo.png");
    unlink("photo.png");
    $img = "INSERT INTO `photos` (`pid`, `user_email`, `image`, `likes`, `photo_time`) VALUES (NULL, '".$_SESSION['login']."', '".$data."', '0', CURRENT_TIMESTAMP)";
    mysql_query($img);
?>