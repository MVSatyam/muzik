<?php
include 'dbconnect.php';
session_start();
if (isset($_SESSION['muzik_user'])) {
  header('location: ./');
} else { ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>muzik | user-signin</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="assets/css/mdb.min.css" rel="stylesheet">

    <link href="assets/css/mdb_pro_min.css" rel="stylesheet">
    <link href="assets/css/mdb_ecommerce.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
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
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top z-depth-0">
        <a href="#" class="navbar-brand m-auto"><i class="fab fa-spotify"></i>&nbsp;
          <h1>muzik</h1>
        </a>
      </nav>
    </header>
    <main>
      <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center no-gutters min-vh-100">
          <div class="col-12 col-md-5 col-lg-4 py-8 py-md-11 mt-2">
            <!-- Heading -->
            <h2 class="font-bold text-center text-white">Sign In</h2>
            <!-- Form -->
            <form class="mb-6" method="post" action="signin.php">
              <!-- Admin Id -->
              <div class="md-outline mt-4">
                <input type="text" id="userId" class="form-control form-control-lg bg-dark font-weight-normal teal-text border-0" name="user_id" autocomplete="off" placeholder="user id" required>
              </div>
              <!-- Password -->
              <div class="md-outline mt-3">
                <input type="password" id="userPasswd" class="form-control form-control-lg bg-dark font-weight-normal teal-text border-0" name="user_passwd" autocomplete="off" placeholder="password" required>
              </div>
              <div class="form-group d-flex justify-content-between mt-3">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" checked="" id="checkbox-remember">
                  <label class="custom-control-label font-weight-bold" for="checkbox-remember">Remember me</label>
                </div>
                <a href="javascript:void(0)" class="font-weight-bold">Reset password</a>
              </div>

              <!-- Submit -->
              <button class="btn btn-primary btn-lg btn-block" type="submit" style="box-shadow: none !important;text-transform: capitalize;" name="signin">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </main>
    <!-- jQuery -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb_ecommerce.min.js"></script>
    <!-- Your custom scripts (optional) -->
    <script type="text/javascript">
      // $(document).ready(function() {
      //   document.documentElement.classList.add('dark-mode')
      // })
    </script>
  </body>

  </html>
<?php
}

if (isset($_POST['signin'])) {
  $userId = stripcslashes($_POST['user_id']);
  $userPasswd = stripcslashes($_POST['user_passwd']);
  $userId = mysqli_real_escape_string($conn, $userId);
  $userPasswd = mysqli_real_escape_string($conn, $userPasswd);

  $sql = "SELECT user_id, user_passwd FROM user_details WHERE user_id='$userId' and user_passwd='$userPasswd'";
  $query = mysqli_query($conn, $sql);

  $count = mysqli_num_rows($query);

  if ($count == 1) {
    $_SESSION['muzik_user'] = $userId;
    header('location: ./');
  } else {
    echo "<script>alert('Invalid Details!!!')</script>";
  }
}
?>