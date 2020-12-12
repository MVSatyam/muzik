<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['user_id']) and isset($_POST['album_name'])){
        $result = '';
        $user_id = $_POST['user_id'];
        $album_name = $_POST['album_name'];

        $sql = "DELETE FROM fav_albums WHERE album_name='$album_name' and user_id='$user_id'";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            $result = 'Removed From Favourite Albums';
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