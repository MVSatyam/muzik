<?php
include 'dbconnect.php';
session_start();
if ($_SESSION['muzik_user'] != NULL) {
  $user_id = $_SESSION['muzik_user'];
  $sql = "SELECT * FROM songs_data ORDER BY url ASC";
  $query = mysqli_query($conn, $sql);

  $songs_list = '';
  $rows = mysqli_num_rows($query);
  if ($rows > 0) {
    $songs_list = $songs_list . '<h1 class="text-success font-small font-weight-bold">All-Songs</h1>';
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
  }

  $genres_list = '';

  $genre_sql = "SELECT DISTINCT genre FROM songs_data ORDER BY genre ASC";
  $genre_query = mysqli_query($conn, $genre_sql);

  if (mysqli_num_rows($genre_query) > 0) {
    while ($genre = mysqli_fetch_assoc($genre_query)) {
      $genres_list = $genres_list . '<option value=' . $genre['genre'] . '>' . $genre['genre'] . '</option>';
    }
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>muzik | index</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Material Design Bootstrap -->
    <link href="assets/css/mdb.min.css" rel="stylesheet" />

    <link href="assets/css/mdb_pro_min.css" rel="stylesheet" />
    <!-- mdb e-commerce -->
    <link href="assets/css/mdb_ecommerce.min.css" rel="stylesheet" />
    <!-- Jquery Confirm -->
    <link href="assets/css/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Aplayer -->
    <link rel="stylesheet" href="assets/css/aplayer.min.css" />
    <!-- notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="assets/css/style.css" />
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

      /* .dark-mode {
        filter: invert(1) hue-rotate(180deg);
      }

      img,
      picture,
      video {
        filter: invert(1) hue-rotate(180deg)
      } */
    </style>
  </head>

  <body class="skin-light bg-dark">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark z-depth-0 sticky-top">
      <a class="navbar-brand white-text font-weight-bold align-items-center" href="#">
        <span><i class="fab fa-spotify fa-1x"></i></span>&nbsp;
        <span class="clearfix d-none d-sm-inline-block">
          <h3>muzik</h3>
        </span>
      </a>
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown ml-2">
          <a class="nav-link white-text font-small font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;" href="#" id="dropdownSearch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search"></i></a>
          <div class="dropdown-menu dropdown-menu-left bg-dark border border-grey-dark z-depth-0 p-2" aria-labelledby="dropdownSearch">
            <div class="input-group">
              <input type="text" id="searchText" class="form-control form-control-sm font-weight-bold rounded-lg teal-text border-0 z-depth-0" name="search_text" autocomplete="off" placeholder="search here..." style="background-color: rgba(255, 255, 255, 0.1);" required>
              <div class="input-group-append">
                <button class="btn btn-sm btn-success px-3 py-0 z-depth-0 waves-effect" type="button" id="search"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown ml-2">
          <a class="nav-link white-text font-small font-weight-bold" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;" href="#" id="menuDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></a>
          <div class="dropdown-menu dropdown-menu-left bg-dark border border-grey-dark z-depth-0" aria-labelledby="menuDropdown">
            <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-home"></i>&nbsp;Home</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="albums/"><i class="fas fa-compact-disc"></i>&nbsp;Albums</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="artists/"><i class="fas fa-user"></i>&nbsp;Artists</a>
            <a class="dropdown-item text-white-50 font-weight-bold" href="favourites/"><i class="fas fa-heart"></i>&nbsp;Favourites</a>
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
            <a class="dropdown-item text-white-50 font-weight-bold" href="signout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;LogOut</a>
          </div>
        </li>
      </ul>
      <!-- </div> -->
    </nav>

    <div class="container p-3" style="margin-bottom: 100px;">
      <div class="inner_container">
        <div class="row d-flex align-items-center p-1 song-filter">
          <div class="col-sm-2 d-flex align-items-center m-1">
            <button id="getSongsList" class="btn btn-outline-dark btn-sm text-nowrap font-weight-bolder text-capitalize" style="box-shadow: none !important;"><span class="teal-text font-weight-bold">shuffle<i class="fas fa-random ml-2"></i></span></button>
          </div>
          <div class="col-sm-4 d-flex align-items-center m-1">
            <span class="teal-text text-nowrap font-weight-bolder ml-2">Sort By: </span>
            <select class="browser-default custom-select custom-select-sm bg-dark teal-text font-weight-bold border border-grey-dark ml-2 sortby" style="width: 150px;">
              <option selected>A-Z</option>
              <option value="artist">Artist</option>
              <option value="album">Album</option>
              <option value="year">Year</option>
            </select>
          </div>
          <div class="col-sm-4 d-flex align-items-center m-1">
            <span class="teal-text font-weight-bolder ml-2">Genre: </span>
            <select class="browser-default custom-select custom-select-sm bg-dark teal-text font-weight-bold border border-grey-dark ml-2 genre" style="width: 150px;">
              <option selected>All</option>
              <!-- <option value="1">Artist</option>
            <option value="2">Album</option>
             -->
              <?php echo $genres_list; ?>
            </select>
          </div>
        </div>
        <div class="songs-list">
          <?php echo $songs_list; ?>
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
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb_ecommerce.min.js"></script>
    <!-- Sweet Alert -->
    <script type="text/javascript" src="assets/js/sweetalert.min.js"></script>
    <!-- Jquery Confirm -->
    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    <script src="assets/js/aplayer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.js"></script>
    <script type="text/javascript">
      $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });

      $(document).on('change', '.sortby, .genre', function() {
        var genre = $('.genre').val();
        var sortby = $('.sortby').val();

        $.ajax({
          url: 'song_filter.php',
          type: 'post',
          data: 'sort_by=' + sortby + '&genre=' + genre,
          success: function(result) {
            // console.log(result);
            $('.songs-list').html(result);
          }
        })
        // console.log(genre);
      });

      $(document).on('click', '#getSongsList', function() {
        var songs = <?php
                    $get_songs = "SELECT title, artist, url FROM songs_data ORDER BY title ASC";
                    $get_songs_query = mysqli_query($conn, $get_songs);

                    $arr_songs = array();
                    while ($row = mysqli_fetch_assoc($get_songs_query)) {
                      $arr_songs[] = $row;
                    }
                    $songs = json_encode($arr_songs);
                    echo $songs;

                    ?>;
        var shuffle_songs = _.shuffle(songs);
        // console.log(songs);
        // console.log(shuffle_songs);
        // $('#musicPlayer').removeClass('d-none');
        const ap = new APlayer({
          container: document.getElementById('musicPlayer'),
          autoplay: true,
          theme: '#009688',
          volume: '1.0',
          audio: shuffle_songs
        });
        ap.list.hide();
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
            'url': song_name,
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
          url: 'addtofav.php',
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
          url: 'removefromfav.php',
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

      $(document).on('click', '#search', function() {
        var text = $('#searchText').val();

        if (text != '') {
          $.ajax({
            url: 'searchsongs.php',
            type: 'get',
            data: 'keys=' + text,
            success: function(result) {
              // console.log(result);
              $('#searchText').val('');
              $('.inner_container').html(result);
            }
          })
        } else {
          toastr.warning('Enter somethig')
        }
      })

      // $(document).ready(function() {
      //   document.documentElement.classList.add('dark-mode')
      // })
    </script>
  </body>

  </html>
<?php
} else {
  header('location: ./signin.php');
}
?>