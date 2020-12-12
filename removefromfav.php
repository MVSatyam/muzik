<?php
include 'dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['song_id'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $song_id = $_POST['song_id'];

        $sql = "DELETE FROM favourites WHERE songid='$song_id' and userid='$user_id'";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Removed from Favourites';
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