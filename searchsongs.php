<?php
include 'dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
  $user_id = $_SESSION['muzik_user'];
  if (isset($_GET['keys'])) {
    $serch_term = $_GET['keys'];

    $result = '';

    $songs_list = '<div class="songs-list">
                    <h5 class="card-title white-text">Songs</h5>';

    $albums_list = '<div class="albums-list">
                    <h5 class="card-title white-text">Albums</h5>
                    <div class="row d-flex align-items-center">';

    $artists_list = '<div class="artists-list">
                    <h5 class="card-title white-text">Artists</h5>
                    <div class="row d-flex align-items-center">';

    $sql = "SELECT * FROM songs_data WHERE title LIKE '%$serch_term%'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
      while ($song_row = mysqli_fetch_assoc($query)) {
        $songs_list = $songs_list . '<div class="card bg-dark white-text z-depth-0 mb-3 cardHover" data-id="' . $song_row['song_id'] . '">
                                                <div class="card-body">
                                                    <a class="white-text song-title font-smaller" id="playSong" data-songid="' . $song_row['song_id'] . '" data-songname="' . $song_row['url'] . '" data-songtitle="' . $song_row['title'] . '" data-songartists="' . $song_row['artist'] . '"><h5 class="card-title font-small">' . $song_row['title'] . '</h5></a>
                                                    <p class="card-text font-weight-bold">
                                                    <span class="mr-2 font-smaller">' . $song_row['album'] . '</span>
                                                    <span class="mr-2 font-smaller">' . $song_row['artist'] . '</span>
                                                    <span class="mr-2 font-smaller">' . $song_row['year'] . '</span>
                                                    <span class="mr-2 font-smaller">' . $song_row['genre'] . '</span>
                                                    <span class="mr-2 font-smaller">' . $song_row['duration'] . '</span>';


        $check_fav_sql = "SELECT * FROM favourites WHERE songid='" . $song_row['song_id'] . "' and userid='$user_id'";
        $check_fav_query = mysqli_query($conn, $check_fav_sql);

        $count = mysqli_num_rows($check_fav_query);
        if ($count == 0) {
          $songs_list = $songs_list . '<span class="mr-2 font-smaller" id="addToFavourites" data-userid="' . $user_id . '" data-songid="' . $song_row['song_id'] . '" style="cursor: pointer;"><i class="far fa-heart"></i></span>
                        </p>
                    </div>
                    </div>';
        } else {
          $songs_list = $songs_list . '<span class="mr-2 font-smaller" id="removeFromFavourites" data-userid="' . $user_id . '" data-songid="' . $song_row['song_id'] . '" style="cursor: pointer;"><i class="fas fa-heart text-success"></i></span>
                        </p>
                    </div>
                    </div>';
        }
      }
    } else {
      $songs_list .= '<h6 class="ml-4">No songs</h6>';
    }
    $songs_list .= '</div>';

    $sql1 = "SELECT * FROM songs_data WHERE album LIKE '%$serch_term%'";
    $query1 = mysqli_query($conn, $sql1);

    $count = mysqli_num_rows($query1);

    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

    if ($count > 0) {
      while ($album = mysqli_fetch_assoc($query1)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $albums_list = $albums_list . '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background: '.$gradient.';">
                            <div class="card-body">
                                <a class="white-text" href="albums/?album=' . $album['album'] . '"><h6 class="card-title">' . $album['album'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playAlbumSongs" data-album="' . $album['album'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    } else {
      $albums_list .= '<h6 class="ml-5">No Albums</h6>';
    }

    $albums_list .= '</div></div>';

    $sql2 = "SELECT * FROM songs_data WHERE artist LIKE '%$serch_term%'";
    $query2 = mysqli_query($conn, $sql2);

    $count = mysqli_num_rows($query2);

    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

    if ($count > 0) {
      while ($artist = mysqli_fetch_assoc($query2)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $artists_list .= '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background: '.$gradient.';">
                            <div class="card-body">
                                <a class="white-text" href="artists/?artist=' . $artist['artist'] . '"><h6 class="card-title">' . $artist['artist'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playAlbumSongs" data-artist="' . $artist['artist'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    } else {
      $artists_list .= '<h6 class="ml-5">No Artists</h6>';
    }

    $artists_list .= '</div></div>';

    $other_albums_list = '<div class="rem_albums-list mt-2">
                            <h5 class="white-text">Other Albums</h5>
                              <div class="row d-flex align-items-center">';

    $other_albums_sql = "SELECT DISTINCT album FROM songs_data WHERE album NOT LIKE '%$serch_term%' ORDER BY RAND() LIMIT 5";
    $other_albums_query = mysqli_query($conn, $other_albums_sql);

    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    if (mysqli_num_rows($other_albums_query) > 0) {
      while ($album = mysqli_fetch_assoc($other_albums_query)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $other_albums_list .= '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background: '.$gradient.';">
                            <div class="card-body">
                                <a class="white-text" href="albums/?album=' . $album['album'] . '"><h6 class="card-title">' . $album['album'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playAlbumSongs" data-album="' . $album['album'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    }
    else {
      $other_albums_list .= '<h6 class="ml-5">No Other Albums</h6>';
    }

    $other_albums_list .= '</div></div>';

    $other_artists_list = '<div class="rem_albums-list mt-2">
                            <h5 class="white-text">Other Artists</h5>
                              <div class="row d-flex align-items-center">';

    $other_artists_sql = "SELECT DISTINCT artist FROM songs_data WHERE artist NOT LIKE '%$serch_term%' ORDER BY RAND() LIMIT 5";
    $other_artists_query = mysqli_query($conn, $other_artists_sql);

    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    if (mysqli_num_rows($other_artists_query) > 0) {
      while ($artist = mysqli_fetch_assoc($other_artists_query)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $other_artists_list .= '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background: '.$gradient.';">
                            <div class="card-body">
                                <a class="white-text" href="artists/?artist=' . $artist['artist'] . '"><h6 class="card-title">' . $artist['artist'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playArtistSongs" data-artist="' . $artist['artist'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    }
    else {
      $other_artists_list .= '<h6 class="ml-5">No Other Artists</h6>';
    }

    $other_artists_list .= '</div></div>';

    $result = '<h3 class="card-title text-success">Results</h3>' . $songs_list . $albums_list . $artists_list. $other_albums_list. $other_artists_list;
    echo $result;
  } else {
    header('location: ./');
  }
} else {
  header('location: ./');
}
