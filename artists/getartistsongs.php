<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
    $user_id = $_SESSION['muzik_user'];

    if (isset($_POST['artist_name'])) {
        $artist_name = $_POST['artist_name'];

        $get_artist_songs_sql = "SELECT title, artist, url FROM songs_data WHERE artist='$artist_name'";
        $get_artist_songs_query = mysqli_query($conn, $get_artist_songs_sql);

        $arr_songs = array();
        while ($row = mysqli_fetch_assoc($get_artist_songs_query)) {
            $arr_songs[] = $row;
        }
        $songs = json_encode($arr_songs);
        echo $songs;
    }
    else {
        header('location: ./');
    }
}
else {
    header('location: ./');
}
?>;