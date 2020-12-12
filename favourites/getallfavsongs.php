<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    if(isset($_POST['favs'])){
        $result = '';
        $user_id = $_SESSION['muzik_user'];

        $sql = "SELECT * FROM favourites ORDER BY id ASC";
        $query = mysqli_query($conn, $sql);

        $arr_fav = array();
        if (mysqli_num_rows($query) > 0) {
            while ($fav_row = mysqli_fetch_assoc($query)) {
                $song_id = $fav_row['songid'];
                $sub_sql = "SELECT * FROM songs_data WHERE song_id=$song_id";
                $sub_query = mysqli_query($conn, $sub_sql);

                $song_row = mysqli_fetch_assoc($sub_query);

                $arr_fav[] = $song_row;
            }
        }
        echo json_encode($arr_fav);
    }
    else {
        header('location: ./');
    }
}
else {
    header('location: ../signin.php');
}
?>