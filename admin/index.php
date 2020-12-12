<?php
include '../dbconnect.php';
session_start();
if ($_SESSION['muzik_admin'] != NULL) {
  $user = $_SESSION['muzik_admin'];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>muzik | index</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../assets/css/mdb.min.css" rel="stylesheet">

    <link href="../assets/css/mdb_pro_min.css" rel="stylesheet">
    <!-- mdb e-commerce -->
    <link href="../assets/css/mdb_ecommerce.min.css" rel="stylesheet">
    <!-- Jquery Confirm -->
    <link href="../assets/css/jquery-confirm.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
      .swal-overlay {
        background-color: rgba(255, 255, 255, 0.1);
      }

      .swal-text {
        font-weight: bold;
      }

      .jconfirm-content {
        font-weight: bold;
      }
    </style>

  </head>

  <body class="skin-light bg-dark">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top z-depth-0">
        <a href="#" class="navbar-brand"><i class="fab fa-spotify"></i>&nbsp;
          <h2>muzik</h2>
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapasableNav" aria-controls="collapasableNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="ml-auto" id="">
          <!-- Links -->
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle white-text font-weight-bold" id="userOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: rgba(255, 255, 255, 0.1);border-radius: 100px;"><i class="fas fa-user"></i> admin</a>
              <div class="dropdown-menu dropdown-menu-right bg-dark border border-grey-dark z-depth-0" aria-labelledby="userOptions">
                <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-user"></i>&nbsp;Profile</a>
                <a class="dropdown-item text-white-50 font-weight-bold" href="#"><i class="fas fa-edit"></i>&nbsp;Edit Profile</a>
                <a class="dropdown-item text-white-50 font-weight-bold" href="signout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;LogOut</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <main>
      <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center no-gutters min-vh-100">
          <div class="col-12 col-md-5 col-lg-4 py-8 py-md-11 mt-70">

            <div class="card mdb-color lighten-4 text-center z-depth-0 light-version py-4 px-5 mt-2">
              <h2 class="font-bold text-center teal-text">Upload Files</h2>

              <form class="md-form" action="./" method="post" enctype="multipart/form-data">
                <div class="file-field">
                  <div class="btn btn-outline-dark btn-rounded waves-effect btn-lg btn-block mb-2" style="box-shadow: none !important;text-transform: capitalize;">
                    <span>Choose files<i class="fas fa-cloud-upload-alt ml-3" aria-hidden="true"></i></span>
                    <input type="file" name="upload_files[]" accept=".mp3" id="uploadFiles" multiple required>
                  </div>
                  <div class="card-text font-weight-bold mt-1" id="totalSizeAndFiles"></div>
                  <button class="btn btn-primary btn-lg btn-block mt-2" type="submit" style="box-shadow: none !important;text-transform: capitalize;" name="upload">Upload Files</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </main>
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
    <!-- Your custom scripts (optional) -->
    <script type="text/javascript">
      // $(document).ready(function() {
      //   swal({
      //     text: 'Upload less than 20 files and Files size should not exceed 20 MB',
      //     icon: 'success'
      //   })
      // })
      $(document).on('change', '#uploadFiles', function() {
        var input = $(this)[0];
        var totFiles = input.files.length;
        var result = 'Total Files: ' + totFiles;

        var totSize = 0;
        for (var i = 0; i < input.files.length; ++i) {
          totSize += input.files.item(i).size;
        }

        result += ", Total Size: " + Math.ceil(totSize / (10 ** 6)) + 'MB';
        $('#totalSizeAndFiles').html(result);
      })
    </script>
  </body>
<?php
} else {
  header('location: signin.php');
}

if (isset($_POST['upload'])) {
  require_once('../assets/getID3/getid3/getid3.php');
  $result = '';
  // $uploaded_file_status = '';
  $not_uploaded_file_status = '';
  $invalid_files = '';
  $file_upload_error = '';
  $uploaded_count = 0;
  $targetDir = '../songs/';
  $filenames = array_filter($_FILES['upload_files']['name']);
  // print_r($filenames);
  foreach ($_FILES['upload_files']['name'] as $key => $val) {

    $filename = basename($_FILES['upload_files']['name'][$key]);
    $targetPath = $targetDir . $filename;
    $extType = pathinfo($targetPath, PATHINFO_EXTENSION);

    if ($extType === 'mp3') {
      if (move_uploaded_file($_FILES['upload_files']['tmp_name'][$key], $targetPath)) {
        $getID3 = new getID3;
        $file = $getID3->analyze($targetPath);

        $song_name = '';
        $title = '';
        $album = '';
        $artist = '';
        $genre = '';
        $track_number = '';
        $year = '';
        $duration = '';

        if (isset($file['filename'])) {
          $song_name = $file['filename'];
        } else {
          $song_name = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['title'][0])) {
          $title = $file['tags']['id3v2']['title'][0];
        } else {
          $title = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['album'][0])) {
          $album = $file['tags']['id3v2']['album'][0];
        } else {
          $album = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['artist'][0])) {
          $artist = $file['tags']['id3v2']['artist'][0];
        } else {
          $artist = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['track_number'][0])) {
          $track_number = $file['tags']['id3v2']['track_number'][0];
        } else {
          $track_number = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['genre'][0])) {
          $genre = $file['tags']['id3v2']['genre'][0];
        } else {
          $genre = 'Unknown';
        }

        if (isset($file['playtime_string'])) {
          $duration = $file['playtime_string'];
        } else {
          $duration = 'Unknown';
        }

        if (isset($file['tags']['id3v2']['year'][0])) {
          $year = $file['tags']['id3v2']['year'][0];
        } else {
          $year = 'Unknown';
        }

        // echo $song_name.'<br>'.$title.'<br>'.$album.'<br>'.$artist.'<br>'.$year.'<br>'.$track_number.'<br>'.$genre.'<br>'.$duration;
        $url = 'songs/'.$song_name;
        $upload_sql = "INSERT INTO songs_data(url, title, album, artist, year, trackno, genre, duration) VALUES ('$url', '$title', '$album', '$artist', '$year', '$track_number', '$genre', '$duration')";
        $upload_query = mysqli_query($conn, $upload_sql);

        if ($upload_query) {
          $uploaded_count += 1;
        } else {
          // $not_uploaded_count += 1;
          $not_uploaded_file_status = $not_uploaded_file_status . 'Error while uploading ' . $filename . '<br>';
        }
      } else {
        $file_upload_error = $file_upload_error . 'Error while uploading ' . $filename . '<br>';
      }
    } else {
      $invalid_files = $invalid_files . 'Invalid: ' . $filename . '<br>';
    }
  }

  $result = $result . $invalid_files;
  $result = $result . $file_upload_error;
  // $result = $result.$invalid_files.'\n\n';
  $result = $result . $not_uploaded_file_status;

  if ($result === '') {
    echo "<script>
            $.alert({
              icon: 'far fa-check-circle',
              title: false,
              content: 'File(s) Uploaded Successfully!!!',
              theme: 'modern',
              type: 'blue',
              buttons: {
                  OK: {
                      keys: ['enter'],
                      btnClass: 'btn-primary',
                      action: function(){
                          location.href = './'
                      }
                  }
              }
          })
        </script>";
    // echo "<script>console.log('File(s) uploded successfully!!!')</script>";
  } else {
    echo "<script>
            $.alert({
              icon: 'far fa-check-circle',
              title: false,
              content: '$result',
              theme: 'modern',
              type: 'blue',
              buttons: {
                  OK: {
                      keys: ['enter'],
                      btnClass: 'btn-primary',
                      action: function(){
                          location.href = './'
                      }
                  }
              }
          })
        </script>";
    // echo "<script>console.log(".$result.")</script>";
  }
}
?>