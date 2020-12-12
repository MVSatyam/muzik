<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['artist_name'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $artist_name = $_POST['artist_name'];

        $sql = "DELETE FROM fav_artists WHERE artist_name='$artist_name' and user_id='$user_id'";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Removed From Favourite Artists';
        }

        echo $result;
    }
    else {
        header('location: ./');
    }
}
else {
    header('location: ../muzik/signin.php');
}
?>