<?php
include 'dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['song_id'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $song_id = $_POST['song_id'];

        $sql = "INSERT INTO favourites(songid, userid) VALUES('$song_id', '$user_id')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Added To Favourites';
        }

        echo $result;
    }
    else {
        header('location: ./');
    }
}
else {
    header('location: ./signin.php');
}
?>