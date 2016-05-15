<?php session_start();
  // error_reporting(0);
  // mysql
  include_once 'koneksi/mysql_lokal.php';
  include_once 'koneksi/mysql_pusat.php';
  include_once 'koneksi/mysql_resepsionis.php';
  include_once 'koneksi/mysql_apoteker.php';

  // session login
  if(empty($_SESSION['user'])){
    header("Location: index.php");

    die("Redirecting to: index.php");
  }

  $status = "";

  $query_pusat = "INSERT INTO rekam_medis SELECT * FROM skripsi_dokter.rekam_medis d ON DUPLICATE KEY UPDATE
                  id_daftar = d.id_daftar, tgl_daftar = d.tgl_daftar, anamnesa = d.anamnesa, pemeriksaan = d.pemeriksaan,
                  diagnosis = d.diagnosis, terapi = d.terapi, status = d.status, id_pelayanan = d.id_pelayanan,
                  id_perawat = d.id_perawat, id_pasien = d.id_pasien, id_dokter = d.id_dokter, id_apoteker = d.id_apoteker, hasil_lab = d.hasil_lab";

  $query_dokter = "INSERT INTO rekam_medis SELECT * FROM skripsi_pusat.rekam_medis p ON DUPLICATE KEY UPDATE
                  id_daftar = p.id_daftar, tgl_daftar = p.tgl_daftar, anamnesa = p.anamnesa, pemeriksaan = p.pemeriksaan,
                  diagnosis = p.diagnosis, terapi = p.terapi, status = p.status, id_pelayanan = p.id_pelayanan,
                  id_perawat = p.id_perawat, id_pasien = p.id_pasien, id_dokter = p.id_dokter, id_apoteker = p.id_apoteker, hasil_lab = p.hasil_lab";

  $query_resepsionis = "INSERT INTO rekam_medis SELECT * FROM skripsi_resepsionis.rekam_medis r ON DUPLICATE KEY UPDATE
                  id_daftar = r.id_daftar, tgl_daftar = r.tgl_daftar, anamnesa = r.anamnesa, pemeriksaan = r.pemeriksaan,
                  diagnosis = r.diagnosis, terapi = r.terapi, status = r.status, id_pelayanan = r.id_pelayanan,
                  id_perawat = r.id_perawat, id_pasien = r.id_pasien, id_dokter = r.id_dokter, id_apoteker = r.id_apoteker, hasil_lab = r.hasil_lab";

  $query_apoteker = "INSERT INTO rekam_medis SELECT * FROM skripsi_apoteker.rekam_medis a ON DUPLICATE KEY UPDATE
                  id_daftar = a.id_daftar, tgl_daftar = a.tgl_daftar, anamnesa = a.anamnesa, pemeriksaan = a.pemeriksaan,
                  diagnosis = a.diagnosis, terapi = a.terapi, status = a.status, id_pelayanan = a.id_pelayanan,
                  id_perawat = a.id_perawat, id_pasien = a.id_pasien, id_dokter = a.id_dokter, id_apoteker = a.id_apoteker, hasil_lab = a.hasil_lab";

  // dokter to pusat
  if (isset($_POST['submit_pusat'])) {
    $result = $mysqli_lokal->query($query_pusat);

    if ($result) {
      $status = "Good Job! Data rekam medis berhasil disinkronisasi.";
    } else {
      $status = "Bad News! Data rekam medis gagal disinkronisasi.";
    }

  }
  // pusat to dokter
  if (isset($_POST['submit_dokter'])) {
    $result = $mysqli_lokal->query($query_dokter);

    if ($result) {
      $status = "Good Job! Data rekam medis berhasil disinkronisasi.";
    } else {
      $status = "Bad News! Data rekam medis gagal disinkronisasi.";
    }

  }
  // dokter to resepsionis
  if (isset($_POST['submit_resepsionis'])) {
    $result = $mysqli_lokal->query($query_resepsionis);

    if ($result) {
      $status = "Good Job! Data rekam medis berhasil disinkronisasi.";
    } else {
      $status = "Bad News! Data rekam medis gagal disinkronisasi.";
    }

  }
  // resepsionis to apoteker
  if (isset($_POST['submit_apoteker'])) {
    $result = $mysqli_lokal->query($query_apoteker);

    if ($result) {
      $status = "Good Job! Data rekam medis berhasil disinkronisasi.";
    } else {
      $status = "Bad News! Data rekam medis gagal disinkronisasi.";
    }
    
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width= device-width, inital-scale=1">

    <title>Poli Klinik UIN Sunan Kalijaga</title>

    <!-- css -->
    <?php include 'css.php'; ?>
  </head>
  <body>
    <nav class="navbar navbar-default navbar-poli">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">UIN SUKA HEALTH CENTER - RESEPSIONIS</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <?php
            include "nav-top.php";
          ?>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <div class="container-fluid isi">
      <div class="row">
        <?php
          include 'nav-side.php';
        ?>
        <div class="col-md-10 content">
          <h3>SINKRONISASI DATA REKAM MEDIS</h3>
          <hr>
          <div class="row">
            <!-- resepsionis sinkronisasi dengan pusat -->
            <div class="col-md-6">
              <fieldset class="sinkron">
                <legend class="sinkron">Sinkronisasi Data Server Dokter - Server Pusat</legend>
                <h3>Tekan tombol 'Sinkronisasi' untuk sinkronisasi data</h3>
                <?php
                  if (isset($_POST['submit_pusat'])) {
                    ?><div class="alert alert-info" role="alert"><?php echo $status; ?></div><?php
                  }
                ?>
                <hr>
                <form action="sinkron_rekam.php" method="post">
                  <input type="submit" class="btn btn-success btn-sinkron" name="submit_pusat" value="SINKRONISASI">
                </form>
                <!-- <button type="button" id="pustorep" class="btn btn-primary btn-sinkron" name="button">SINKRONISASI PUSAT KE RESEPSIONIS</button> -->
              </fieldset>
            </div>
            <!-- pusat sinkronisasi dengan resepsionis -->
            <div class="col-md-6">
              <fieldset class="sinkron">
                <legend class="sinkron">Sinkronisasi Data Server Pusat - Server Dokter</legend>
                <h3>Tekan tombol 'Sinkronisasi' untuk sinkronisasi data</h3>
                <?php
                  if (isset($_POST['submit_dokter'])) {
                    ?><div class="alert alert-info" role="alert"><?php echo $status; ?></div><?php
                  }
                ?>
                <hr>
                <form action="sinkron_rekam.php" method="post">
                  <input type="submit" class="btn btn-success btn-sinkron" name="submit_dokter" value="SINKRONISASI">
                </form>
                <!-- <button type="button" id="pustorep" class="btn btn-primary btn-sinkron" name="button">SINKRONISASI PUSAT KE RESEPSIONIS</button> -->
              </fieldset>
            </div>
          </div>
          <div class="row">
            <!-- resepsionis sinkronisasi dengan pusat -->
            <div class="col-md-6">
              <fieldset class="sinkron">
                <legend class="sinkron">Sinkronisasi Data Server Dokter - Server Resepsionis</legend>
                <h3>Tekan tombol 'Sinkronisasi' untuk sinkronisasi data</h3>
                <?php
                  if (isset($_POST['submit_resepsionis'])) {
                    ?><div class="alert alert-info" role="alert"><?php echo $status; ?></div><?php
                  }
                ?>
                <hr>
                <form action="sinkron_rekam.php" method="post">
                  <input type="submit" class="btn btn-success btn-sinkron" name="submit_resepsionis" value="SINKRONISASI">
                </form>
                <!-- <button type="button" id="pustorep" class="btn btn-primary btn-sinkron" name="button">SINKRONISASI PUSAT KE RESEPSIONIS</button> -->
              </fieldset>
            </div>
            <!-- pusat sinkronisasi dengan resepsionis -->
            <div class="col-md-6">
              <fieldset class="sinkron">
                <legend class="sinkron">Sinkronisasi Data Server Dokter - Server Apoteker</legend>
                <h3>Tekan tombol 'Sinkronisasi' untuk sinkronisasi data</h3>
                <?php
                  if (isset($_POST['submit_apoteker'])) {
                    ?><div class="alert alert-info" role="alert"><?php echo $status; ?></div><?php
                  }
                ?>
                <hr>
                <form action="sinkron_rekam.php" method="post">
                  <input type="submit" class="btn btn-success btn-sinkron" name="submit_apoteker" value="SINKRONISASI">
                </form>
                <!-- <button type="button" id="pustorep" class="btn btn-primary btn-sinkron" name="button">SINKRONISASI PUSAT KE RESEPSIONIS</button> -->
              </fieldset>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- js -->
    <?php include 'js.php'; ?>
  </body>
</html>
