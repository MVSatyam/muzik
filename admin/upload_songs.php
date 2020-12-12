<?php
include_once 'dbconnect.php';
require_once('assets/getID3/getid3/getid3.php');

if (isset($_POST['upload'])) {
    $result = '';
    // $uploaded_file_status = '';
    $not_uploaded_file_status = '';
    $invalid_files = '';
    $file_upload_error = '';
    $uploaded_count = 0;
    $targetDir = 'songs/';
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

                $upload_sql = "INSERT INTO songs_data(songname, title, album, artists, year, trackno, genre, duration) VALUES ('$song_name', '$title', '$album', '$artist', '$year', '$track_number', '$genre', '$duration')";
                $upload_query = mysqli_query($conn, $upload_sql);
                
                if ($upload_query) {
                    $uploaded_count += 1;
                }
                else {
                    // $not_uploaded_count += 1;
                    $not_uploaded_file_status = $not_uploaded_file_status.'Error while uploading '.$filename.'<br>';
                }

                
            } else {
                $file_upload_error = $file_upload_error.'Error while uploading '.$filename.'<br>';
            }
        } else {
            $invalid_files = $invalid_files.'Invalid: '.$filename.'<br>';
        }
    }

    $result = $result.$invalid_files;
    $result = $result.$file_upload_error;
    // $result = $result.$invalid_files.'\n\n';
    $result = $result.$not_uploaded_file_status;

    if ($result === '') {
        echo "<script src='assets/js/sweetalert.min.js'>
            <script>
              swal({
                text: File(s) uploaded successfully!!!,
                icon: 'success',
              })
            </script>";
        // echo "<script>console.log('File(s) uploded successfully!!!')</script>";
      } else {
        echo "<script src='assets/js/sweetalert.min.js'>
            <script>
              swal({
                text: " . $result . ",
                icon: 'success',
              })
            </script>";
        // echo "<script>console.log(".$result.")</script>";
      }
}
