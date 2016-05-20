<?php session_start();
  // error_reporting(0);
  // oracle
  include_once 'koneksi/koneksi_lokal.php';
  include_once 'koneksi/koneksi_pusat.php';
  include_once 'koneksi/koneksi_resepsionis.php';
  include_once 'koneksi/koneksi_apoteker.php';
  // mysql
  include_once 'koneksi/mysql_lokal.php';
  include_once 'koneksi/mysql_pusat.php';
  include_once 'koneksi/mysql_resepsionis.php';
  include_once 'koneksi/mysql_apoteker.php';

  // timezone
  date_default_timezone_set('Asia/Jakarta');

  // session login
  if(empty($_SESSION['user'])){
    header("Location: index.php");

    die("Redirecting to: index.php");
  }

  // insert data to database
  $status_alert = "";

  if(isset($_POST['submit'])){
    $id_daftar = $_POST['id_daftar'];
    $id_dokter = $_POST['daftar_dokter'];
    $anamnesa = $_POST['anamnesa'];
    $diagnosis = $_POST['diagnosis'];
    $pemeriksaan = $_POST['pemeriksaan'];
    $terapi = $_POST['terapi'];
    $hasil_lab = $_POST['hasil_lab'];
    $status = $_POST['status'];

    // sample query merge di mysql
    $query_merge = "INSERT INTO rekam_medis SELECT * FROM skripsi_resepsionis.rekam_medis r ON DUPLICATE KEY UPDATE id_daftar = r.id_daftar";

    // query
    $query = "UPDATE rekam_medis SET id_dokter = '$id_dokter', anamnesa = '$anamnesa', diagnosis = '$anamnesa', pemeriksaan = '$pemeriksaan',
              terapi = '$terapi', hasil_lab = '$hasil_lab', status = '$status' WHERE id_daftar = '$id_daftar'";

    // logika basis data terdistribusi
    if ($stat_mylokal == "ON" && $stat_mypusat == "ON" && $stat_myresepsionis == "ON" && $stat_myapoteker == "ON") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database resepsionis
        $mysqli_resepsionis->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter, Pusat, Resepsionis, dan Apoteker!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "OFF" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "OFF") {
        // input to database lokal
        $mysqli_lokal->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "ON" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "OFF") {
        // input to database pusat
        $mysqli_pusat->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Pusat!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "OFF" && $stat_myresepsionis == "ON" && $stat_myapoteker == "OFF") {
        // input to database resepsionis
        $mysqli_resepsionis->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Resepsionis!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "OFF" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "ON") {
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Apoteker!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "ON" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "OFF") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database pusat
        $mysqli_pusat->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter dan Pusat!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "OFF" && $stat_myresepsionis == "ON" && $stat_myapoteker == "OFF") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database resepsionis
        $mysqli_resepsionis->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter dan Resepsionis!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "OFF" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "ON") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter dan Apoteker!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "ON" && $stat_myresepsionis == "ON" && $stat_myapoteker == "OFF") {
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database resepsionis
        $mysqli_resepsionis->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Pusat dan Resepsionis!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "ON" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "ON") {
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Pusat dan Apoteker!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "OFF" && $stat_myresepsionis == "ON" && $stat_myapoteker == "ON") {
        // input to database resepsionis
        $mysqli_resepsionis->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Resepsionis dan Apoteker!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "OFF" && $stat_myresepsionis == "ON" && $stat_myapoteker == "ON") {
      // input to database lokal
      $mysqli_lokal->query($query);
      // input to database resepsionis
      $mysqli_resepsionis->query($query);
      // input to database apoteker
      $mysqli_apoteker->query($query);

      $status_alert = "Data berhasil ditambahkan pada server Dokter, Resepsionis, dan Apoteker!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "ON" && $stat_myresepsionis == "OFF" && $stat_myapoteker == "ON") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter, Pusat, dan Apoteker!";

    } elseif ($stat_mylokal == "ON" && $stat_mypusat == "ON" && $stat_myresepsionis == "ON" && $stat_myapoteker == "OFF") {
        // input to database lokal
        $mysqli_lokal->query($query);
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database resepsionis
        $mysqli_resepsionis->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Dokter, Pusat, dan Resepsionis!";

    } elseif ($stat_mylokal == "OFF" && $stat_mypusat == "ON" && $stat_myresepsionis == "ON" && $stat_myapoteker == "ON") {
        // input to database pusat
        $mysqli_pusat->query($query);
        // input to database resepsionis
        $mysqli_resepsionis->query($query);
        // input to database apoteker
        $mysqli_apoteker->query($query);

        $status_alert = "Data berhasil ditambahkan pada server Pusat, Resepsionis, dan Apoteker!";

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
          <a class="navbar-brand" href="index.php">UIN SUKA HEALTH CENTER - DOKTER</a>
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
        <div class="col-md-10 content main_baru">
          <h3>PENGOBATAN PASIEN</h3>
          <div class="clear"></div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <?php
                if (isset($_POST['submit'])) {
                  ?><div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $status_alert; ?>
                  </div><?php
                }
              ?>
              <form action="pengobatan.php" method="post" autocomplete="off">
              <div class="row">
                <!-- form kiri -->
                <div class="col-md-6">
                  <div class="kotak">
                    <div class="form-group">
                      <label>No. Pendaftaran</label>
                      <input type="text" name="id_daftar" class="form-control" id="id_daftar">
                      <small class="detail-form">Nomor pendaftaran pasien. Harus diisi.</small>
                    </div>
                    <div class="form-group">
                      <label>ID Pasien</label>
                      <input type="text" name="id_pasien" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Tanggal Daftar</label>
                      <input type="text" name="tgl_daftar" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>ID Pelayanan</label>
                      <input type="text" name="id_pelayanan" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>ID Perawat</label>
                      <input type="text" name="id_perawat" class="form-control" readonly="true">
                    </div>
                  </div>
                  <!-- button -->
                  <div class="btn-daftar">
                    <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                    </div>
                  </div>
                </div>
                <!-- end form kiri -->
                <!-- form kanan -->
                <div class="col-md-6">
                  <!-- form dokter -->
                  <div class="kotak">
                    <div class="form-group">
                      <label>Daftar Dokter</label>
                      <select class="form-control" name="daftar_dokter">
                        <option>-- Pilih Dokter --</option>
                        <?php
                          $data_dokter = "SELECT * FROM dokter";

                          // logika distribusi
                          if ($status_lokal == "ON" && $status_pusat == "ON") {
                            $dokter = oci_parse($conn_lokal, $data_dokter);
                            oci_execute($dokter);

                            while (($row = oci_fetch_array($dokter, OCI_BOTH)) != false) {
                              ?><option value="<?php echo $row['ID_DOKTER']; ?>"><?php echo $row['NAMA_DOKTER']; ?></option> <?php
                            }
                          } elseif ($status_lokal == "ON" && $status_pusat == "OFF") {
                            $dokter = oci_parse($conn_lokal, $data_dokter);
                            oci_execute($dokter);

                            while (($row = oci_fetch_array($dokter, OCI_BOTH)) != false) {
                              ?><option value="<?php echo $row['ID_DOKTER']; ?>"><?php echo $row['NAMA_DOKTER']; ?></option> <?php
                            }
                          } elseif ($status_lokal == "OFF" && $status_pusat == "ON") {
                            $dokter = oci_parse($conn_pusat, $data_dokter);
                            oci_execute($dokter);

                            while (($row = oci_fetch_array($dokter, OCI_BOTH)) != false) {
                              ?><option value="<?php echo $row['ID_DOKTER']; ?>"><?php echo $row['NAMA_DOKTER']; ?></option> <?php
                            }
                          }

                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Anamnesa</label>
                      <input type="text" name="anamnesa" class="form-control">
                      <small class="detail-form">Anamnesa dokter. Harus diisi. Jika tidak ada isikan 'Tidak Ada'.</small>
                    </div>
                    <div class="form-group">
                      <label>Diagnosis</label>
                      <input type="text" name="diagnosis" class="form-control">
                      <small class="detail-form">Hasil diagnosis dokter. Harus diisi. Jika tidak ada isikan 'Tidak Ada'.</small>
                    </div>
                    <div class="form-group">
                      <label>Hasil Pemeriksaan</label>
                      <input type="text" name="pemeriksaan" class="form-control">
                      <small class="detail-form">Hasil pemeriksaan dokter. Harus diisi. Jika tidak ada isikan 'Tidak Ada'.</small>
                    </div>
                    <div class="form-group">
                      <label>Terapi</label>
                      <input type="text" name="terapi" class="form-control">
                      <small class="detail-form">Terapi pasien. Harus diisi. Jika tidak ada isikan 'Tidak Ada'.</small>
                    </div>
                    <div class="form-group">
                      <label>Hasil Laboratorium</label>
                      <input type="text" name="hasil_lab" class="form-control">
                      <small class="detail-form">Hasil Laboratorium Pasien. Jika tidak ada isikan 'Tidak Ada'.</small>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status">
                        <option>-- Pilih Status --</option>
                        <option value="sudah">Sudah diperiksa</option>
                        <option value="belum">Belum diperiksa</option>
                      </select>
                      <small class="detail-form">Status pengobatan pasien. Harus diisi.</small>
                    </div>
                  </div>
                  </div>
                </div>
                <!-- end of form kanan -->
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- js -->
    <?php
      include 'js.php';
    ?>

    <script type="text/javascript">
      $(function(){
        $("#id_daftar").autocomplete({
          source: "datapengobatan.php",
          minLength:2,
          select:function(event, data){
            $('input[name=id_pasien]').val(data.item.id_pasien);
            $('input[name=tgl_daftar]').val(data.item.tgl_daftar);
            $('input[name=id_pelayanan]').val(data.item.id_pelayanan);
            $('input[name=id_perawat]').val(data.item.id_perawat);
          }
        })
      });
    </script>
  </body>
</html>
