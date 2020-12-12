<?php
$conn = mysqli_connect("localhost", "root", "mvsatyam@n150628", "muzik");
date_default_timezone_set("Asia/Kolkata");

if ($conn) {
  # Connected
} else {
  echo "Not Connected";
}
