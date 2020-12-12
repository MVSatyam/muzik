<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['artist_name'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $artist_name = $_POST['artist_name'];

        $sql = "INSERT INTO fav_artists(artist_name, user_id) VALUES('$artist_name', '$user_id')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Added To Favourite Artists';
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