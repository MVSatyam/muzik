<?php
include 'dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
  $user_id = $_SESSION['muzik_user'];
  $songs_list = '';
  if (isset($_POST['sort_by']) and isset($_POST['genre'])) {
    $sortby = $_POST['sort_by'];
    $genre = $_POST['genre'];

    if ($sortby === 'artist') {
      $sql = "SELECT DISTINCT artist FROM songs_data ORDER BY artist ASC";
      $query = mysqli_query($conn, $sql);

      while ($artist_row = mysqli_fetch_assoc($query)) {
        $artist_name = $artist_row['artist'];
        $sql_art_genre = '';
        if ($genre === 'All') {
          $sql_art_genre = "SELECT * FROM songs_data WHERE artist='$artist_name' ORDER BY url ASC";
        } else {
          $sql_art_genre = "SELECT * FROM songs_data WHERE artist='$artist_name' and genre='$genre' ORDER BY url ASC";
        }

        $query_art_genre = mysqli_query($conn, $sql_art_genre);

        $count = mysqli_num_rows($query_art_genre);
        if ($count > 0) {
          $songs_list = $songs_list . '<h1 class="text-success font-small font-weight-bold">' . $artist_name . '</h1>';
          while ($song_row = mysqli_fetch_assoc($query_art_genre)) {
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
        }
      }
    } else if ($sortby === 'album') {
      $sql = "SELECT DISTINCT album FROM songs_data ORDER BY album ASC";
      $query = mysqli_query($conn, $sql);

      while ($album_row = mysqli_fetch_assoc($query)) {
        $album_name = $album_row['album'];
        $sql_album_genre = '';
        if ($genre === 'All') {
          $sql_album_genre = "SELECT * FROM songs_data WHERE album='$album_name' ORDER BY url ASC";
        } else {
          $sql_album_genre = "SELECT * FROM songs_data WHERE album='$album_name' and genre='$genre' ORDER BY url ASC";
        }

        $query_album_genre = mysqli_query($conn, $sql_album_genre);

        $count = mysqli_num_rows($query_album_genre);
        if ($count > 0) {
          $songs_list = $songs_list . '<h1 class="text-success font-small font-weight-bold">' . $album_name . '</h1>';
          while ($song_row = mysqli_fetch_assoc($query_album_genre)) {
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
        }
      }
    } else if ($sortby === 'A-Z') {
      $sql = '';
      if ($genre === 'All') {
        $sql = "SELECT * FROM songs_data ORDER BY url ASC";
      } else {
        $sql = "SELECT * FROM songs_data WHERE genre='$genre' ORDER BY url ASC";
      }

      $query = mysqli_query($conn, $sql);

      $rows = mysqli_num_rows($query);
      if ($rows > 0) {
        $songs_list = $songs_list . '<h1 class="text-success font-small font-weight-bold">' . $genre . '-Songs</h1>';
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
      }
    } else if ($sortby === 'year') {
      $sql = "SELECT DISTINCT year FROM songs_data ORDER BY year ASC";
      $query = mysqli_query($conn, $sql);

      while ($year_row = mysqli_fetch_assoc($query)) {
        $year_name = $year_row['year'];
        $sql_year_genre = '';
        if ($genre === 'All') {
          $sql_year_genre = "SELECT * FROM songs_data WHERE year='$year_name' ORDER BY url ASC";
        } else {
          $sql_year_genre = "SELECT * FROM songs_data WHERE year='$year_name' and genre='$genre' ORDER BY url ASC";
        }

        $query_year_genre = mysqli_query($conn, $sql_year_genre);

        $count = mysqli_num_rows($query_year_genre);
        if ($count > 0) {
          $songs_list = $songs_list . '<h1 class="text-success font-small font-weight-bold">' . $year_name . '</h1>';
          while ($song_row = mysqli_fetch_assoc($query_year_genre)) {
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
        }
      }
    }
    echo $songs_list;
  } else {
    header('location: ./');
  }
} else {
  header('location: ./signin.php');
}
