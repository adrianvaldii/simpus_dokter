<?php
  // error_reporting(0);
  $host = "localhost";
  $username = "dokter";
  $password = "dokter";
  $db = "skripsi_dokter";

  $mysqli_lokal = new mysqli($host, $username, $password, $db);

  if ($mysqli_lokal->connect_errno) {
    $stat_mylokal = "OFF";
  } else {
    $stat_mylokal = "ON";
  }
?>
