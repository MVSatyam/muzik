<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
  $user_id = $_SESSION['muzik_user'];

  $album_songs_list = '';
  $rem_album_list = '';
  $albums_list = '';

  if (isset($_GET['album'])) {
    $album_name = $_GET['album'];

    $album_songs_list_sql = "SELECT * FROM songs_data WHERE album='$album_name' ORDER BY album ASC";
    $album_songs_list_query = mysqli_query($conn, $album_songs_list_sql);

    $album_songs_list = $album_songs_list . '<div class="d-flex align-items-center">
                                                    <div class="m-2">
                                                        <button id="playAlbumSongs" data-album="' . $album_name . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                                                    </div>
                                                    <div class="mt-2">
                                                        <h4 class="text-success">' . $album_name . '</h4>
                                                    </div>';
    $check_fav_sql = "SELECT * FROM fav_albums WHERE album_name='" . $album_name . "' and user_id='$user_id'";
    $check_fav_query = mysqli_query($conn, $check_fav_sql);

    $count = mysqli_num_rows($check_fav_query);
    if ($count == 0) {
      $album_songs_list = $album_songs_list . '<div class="m-2">
                                                      <span class="font-smaller" id="addToFavAlbums" data-userid="' . $user_id . '" data-album="' . $album_name . '" style="cursor: pointer;"><i class="far fa-heart fa-2x"></i></span>
                                                    </div>
                                                </div>';
    } else {
      $album_songs_list = $album_songs_list . '<div class="m-2">
                                                      <span class="font-smaller" id="removeFromFavAlbums" data-userid="' . $user_id . '" data-album="' . $album_name . '" style="cursor: pointer;"><i class="fas fa-heart text-success fa-2x"></i></span>
                                                    </div>
                                                </div>';
    }

    while ($song_row = mysqli_fetch_assoc($album_songs_list_query)) {
      $album_songs_list = $album_songs_list . '<div class="card bg-dark white-text z-depth-0 mb-3 cardHover" data-id="' . $song_row['song_id'] . '">
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
        $album_songs_list = $album_songs_list . '<span class="mr-2 font-smaller" id="addToFavourites" data-userid="' . $user_id . '" data-songid="' . $song_row['song_id'] . '" style="cursor: pointer;"><i class="far fa-heart"></i></span>
                  </p>
                </div>
              </div>';
      } else {
        $album_songs_list = $album_songs_list . '<span class="mr-2 font-smaller" id="removeFromFavourites" data-userid="' . $user_id . '" data-songid="' . $song_row['song_id'] . '" style="cursor: pointer;"><i class="fas fa-heart text-success"></i></span>
                  </p>
                </div>
              </div>';
      }
    }

    $rem_album_sql = "SELECT DISTINCT album FROM songs_data WHERE album != '$album_name' ORDER BY album ASC";
    $rem_album_query = mysqli_query($conn, $rem_album_sql);

    $count = mysqli_num_rows($rem_album_query);
    
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

    if ($count > 0) {
      while ($album = mysqli_fetch_assoc($rem_album_query)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $rem_album_list = $rem_album_list . '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background:'.$gradient.'">
                            <div class="card-body">
                                <a class="white-text" href="./?album=' . $album['album'] . '"><h6 class="card-title">' . $album['album'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playAlbumSongs" data-album="' . $album['album'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    }
  } else {

    $sql = "SELECT DISTINCT album FROM songs_data ORDER BY album ASC";
    $query = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($query);

    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

    if ($count > 0) {
      while ($album = mysqli_fetch_assoc($query)) {
        $color1 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $color2 = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
        $angle = rand(0, 360);

        $gradient = 'linear-gradient('.$angle.'deg, '.$color1.', '.$color2.')';
        $albums_list = $albums_list . '<div class="col-xl-2 col-md-3 col-sm-4 col mt-3">
                        <div class="card bg-dark z-depth-0 white-text" style="height: 150px;background: '.$gradient.'">
                            <div class="card-body">
                                <a class="white-text" href="./?album=' . $album['album'] . '"><h6 class="card-title">' . $album['album'] . '</h6></a>
                            </div>
                            <div class="card-footer border-0 d-none">
                                <button id="playAlbumSongs" data-album="' . $album['album'] . '" type="button" class="btn btn-success p-3 rounded-circle float-right z-depth-0" style="cursor: default;"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>';
      }
    }
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>muzik | albums</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Material Design Bootstrap -->
    <link href="../assets/css/mdb.min.css" rel="stylesheet" />

    <link href="../assets/css/mdb_pro_min.css" rel="stylesheet" />
    <!-- mdb e-commerce -->
    <link href="../assets/css/mdb_ecommerce.min.css" rel="stylesheet" />
    <!-- Jquery Confirm -->
    <link href="../assets/css/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Aplayer -->
    <link rel="stylesheet" href="../assets/css/aplayer.min.css" />
    <!-- notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <style>
      .toast-message {
        font-weight: bold;
      }

      .aplayer-list {
        color: #343a40;
        font-weight: bold;
      }

      .aplayer-body {
        background-color: #343a40;
      }

      .aplayer-title {
        color: #FFF;
        font-weight: bold;
      }

      .aplayer-author,
      .aplayer-time-inner,
      svg {
        font-weight: bold;
      }
    </style>
  </head>

  <body class="skin-light bg-dark">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark z-depth-0 sticky-top">
      <a class="navbar-brand white-text font-weight-bold align-items-center" href="../">
        <span><i class="fab fa-spotify fa-1x"></i></span>&nbsp;
        <span class="clearfix d-none d-sm-inline-block">
          <h3>muzik</h3>
        </span>
      </a>
      <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown ml-2">
          <a class="nav-link white-text font-small font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;" href="#" id="menuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
          <div class="dropdown-menu dropdown-menu-left bg-dark border border-grey-dark z-depth-0" aria-labelledby="menuDropdown">
            <a class="dropdown-item text-white-50 font-weight-bold" href="../"><i class="fas fa-home"></i>&nbsp;Home</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-compact-disc"></i>&nbsp;Albums</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="../artists/"><i class="fas fa-user"></i>&nbsp;Artists</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="../favourites/"><i class="fas fa-heart"></i>&nbsp;Favourites</a>
          </div>
        </li>
        <li class="nav-item ml-2">
          <a class="nav-link white-text font-small font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;"><i class="fas fa-envelope"></i> <span class="clearfix d-none d-sm-inline-block">Contact</span></a>
        </li>
        <li class="nav-item ml-2">
          <a class="nav-link white-text font-small font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;"><i class="fas fa-comments"></i> <span class="clearfix d-none d-sm-inline-block">Support</span></a>
        </li>
        <li class="nav-item dropdown ml-2">
          <a class="nav-link dropdown-toggle font-small white-text font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user"></i> <?php echo $user_id; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right bg-dark border border-grey-dark z-depth-0" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-user"></i>&nbsp;Profile</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-edit"></i>&nbsp;Edit Profile</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="../signout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;LogOut</a>
          </div>
        </li>
      </ul>
      <!-- </div> -->
    </nav>

    <div class="container p-3" style="margin-bottom: 100px;">
      <div class="songs-list">
        <?php
        if ($album_songs_list != '') {
          echo $album_songs_list;
        }
        ?>
      </div>
      <div class="rem_albums-list">
        <?php
        if ($rem_album_list != '') {
          echo '<h4 class="text-success">Other Albums</h4>
                        <div class="row d-flex align-items-center p-1">' . $rem_album_list . '</div>';
        }
        ?>
      </div>
      <div class="albums-list">
        <div class="row d-flex align-items-center p-1">
          <?php
          if ($albums_list != '') {
            echo $albums_list;
          }
          ?>
        </div>
      </div>
    </div>

    <footer class="page-footer bg-dark fixed-bottom border-top border-grey-dark">
      <div class="container p-2">
        <div class="music-player" id="musicPlayer">
        </div>
      </div>
    </footer>
    <!-- jQuery -->
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="../assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="../assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="../assets/js/mdb_ecommerce.min.js"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="../assets/js/sweetalert.min.js"></script>
    <!-- Jquery Confirm -->
    <script type="text/javascript" src="../assets/js/jquery-confirm.min.js"></script>
    <script src="../assets/js/aplayer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.js"></script> -->
    <script type="text/javascript">
      $(document).on('mouseover', '.card', function() {
        $(this).children('.card-footer').removeClass('d-none');
      })
      $(document).on('mouseleave', '.card', function() {
        $(this).children('.card-footer').addClass('d-none');
      })

      $(document).on('click', '#playSong', function() {
        var song_id = $(this).data('songid');
        // console.log(song_id);
        var song_name = $(this).data('songname');
        var song_title = $(this).data('songtitle');
        var song_artists = $(this).data('songartists');

        const ap = new APlayer({
          container: document.getElementById('musicPlayer'),
          autoplay: true,
          theme: '#009688',
          volume: '1.0',
          loop: 'all',
          audio: [{
            'name': song_title,
            'artist': song_artists,
            'url': '../' + song_name,
          }]
        });
      })

      $(document).on('mouseover', '#playSong', function() {
        $(this).addClass('teal-text').removeClass('white-text')
      })

      $(document).on('mouseleave', '#playSong', function() {
        $(this).addClass('white-text').removeClass('teal-text')
      })

      $(document).on('click', '#addToFavourites', function() {
        var userid = $(this).data('userid');
        var songid = $(this).data('songid');
        $.ajax({
          url: '../addtofav.php',
          type: 'post',
          data: 'user_id=' + userid + '&song_id=' + songid,
          success: function(data) {
            toastr.success(data);
          }
        })
        $(this).empty();
        $(this).append('<i class="fas fa-heart text-success"></i>');
        $(this).removeAttr('id').attr('id', 'removeFromFavourites');
      })

      $(document).on('click', '#removeFromFavourites', function() {
        var userid = $(this).data('userid');
        var songid = $(this).data('songid');

        $.ajax({
          url: '../removefromfav.php',
          type: 'post',
          data: 'user_id=' + userid + '&song_id=' + songid,
          success: function(data) {
            toastr.info(data);
          }
        })
        $(this).empty();
        $(this).append('<i class="far fa-heart"></i>');
        $(this).removeAttr('id').attr('id', 'addToFavourites');
      })

      $(document).on('click', '#addToFavAlbums', function() {
        var userid = $(this).data('userid');
        var albumname = $(this).data('album');

        $.ajax({
          url: 'addtofavalbums.php',
          type: 'post',
          data: 'user_id=' + userid + '&album_name=' + albumname,
          success: function(data) {
            toastr.success(data);
          }
        })

        $(this).empty();
        $(this).append('<i class="fas fa-heart text-success fa-2x"></i>');
        $(this).removeAttr('id').attr('id', 'removeFromFavAlbums');
      })

      $(document).on('click', '#removeFromFavAlbums', function() {
        var userid = $(this).data('userid');
        var albumname = $(this).data('album');

        $.ajax({
          url: 'removefromfavalbums.php',
          type: 'post',
          data: 'user_id=' + userid + '&album_name=' + albumname,
          success: function(data) {
            toastr.info(data);
          }
        })

        $(this).empty();
        $(this).append('<i class="far fa-heart fa-2x"></i>');
        $(this).removeAttr('id').attr('id', 'addToFavAlbums');
      })

      $(document).on('click', '#playAlbumSongs', function() {
        $(this).removeAttr('id').attr('id', 'pause');
        $(this).children('i').removeClass('fa-play').addClass('fa-pause');
        var albumName = $(this).data('album');

        $.ajax({
          url: 'getalbumsongs.php',
          type: 'post',
          data: 'album_name=' + albumName,
          success: function(result) {
            // console.log(result);
            var songs = result.slice(0, result.length - 1);
            songs = $.parseJSON(songs);

            for (var i in songs) {
              var song = songs[i].url;
              songs[i].url = '../' + song;
            }

            const ap = new APlayer({
              container: document.getElementById('musicPlayer'),
              autoplay: true,
              theme: '#009688',
              volume: '1.0',
              audio: songs
            });

            ap.list.hide();
          }
        })
      })

      $(document).on('click', '#pause', function() {
        $(this).removeAttr('id').attr('id', 'play');
        $('.aplayer-button').trigger('click');
        $(this).children('i').removeClass('fa-pause').addClass('fa-play');
      })

      $(document).on('click', '#play', function() {
        $(this).removeAttr('id').attr('id', 'pause');
        $('.aplayer-button').trigger('click');
        $(this).children('i').removeClass('fa-play').addClass('fa-pause');
      })

      // $(document).on('click', '.aplayer-button', function(){

      // })
    </script>
  </body>

  </html>
<?php
} else {
  header('location: ../');
}
?>