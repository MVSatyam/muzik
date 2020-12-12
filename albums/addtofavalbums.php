<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['album_name'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $album_name = $_POST['album_name'];

        $sql = "INSERT INTO fav_albums(album_name, user_id) VALUES('$album_name', '$user_id')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Added To Favourite Albums';
        }

        echo $result;
    }
    else {
        header('location: ./');
    }
}
else {
    header('location: ../signin.php');
}
?>