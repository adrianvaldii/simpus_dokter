<?php
  include 'koneksi/koneksi_lokal.php';
  include 'koneksi/koneksi_pusat.php';
  include 'koneksi/koneksi_resepsionis.php';

  // timezone
  date_default_timezone_set('Asia/Jakarta');

  // generate id daftar berobat
  $caridata = "SELECT max(id_daftar) as id_rekam_medis from rekam_medis";
  $datakode = oci_parse($conn_lokal, $caridata);
  oci_execute($datakode);
  $cari = oci_fetch_array($datakode, OCI_BOTH);

  if($cari){
    $id_rekam_medis = $cari[0] + 1;
  }else{
    $date = date("Ymd");
    $id_rekam_medis = $date . "001";
  }

  // insert data to database
  $status = "";

  if(isset($_POST['submit'])){
    $id_daftar = $_POST['id_daftar'];
    $id_dokter = $_POST['daftar_dokter'];
    $anamnesa = $_POST['anamnesa'];
    $diagnosis = $_POST['diagnosis'];
    $pemeriksaan = $_POST['pemeriksaan'];
    $terapi = $_POST['terapi'];
    $status = $_POST['status'];

    // input to database dokter
    $query_dokter = oci_parse($conn_lokal, "UPDATE rekam_medis SET id_dokter = :id_dokter, anamnesa = :anamnesa, diagnosis = :diagnosis, pemeriksaan = :pemeriksaan, terapi = :terapi, status = :status");
    oci_bind_by_name($query_dokter, ":id_dokter", $id_dokter);
    oci_bind_by_name($query_dokter, ":anamnesa", $anamnesa);
    oci_bind_by_name($query_dokter, ":diagnosis", $diagnosis);
    oci_bind_by_name($query_dokter, ":pemeriksaan", $pemeriksaan);
    oci_bind_by_name($query_dokter, ":terapi" , $terapi);
    oci_bind_by_name($query_dokter, ":status" , $status);

    $result_dokter = oci_execute($query_dokter);
    oci_commit($conn_lokal);

    oci_close($conn_lokal);

    // input to database resepsionis
    $query_resepsionis = oci_parse($conn_resepsionis, "UPDATE rekam_medis SET id_dokter = :id_dokter, anamnesa = :anamnesa, diagnosis = :diagnosis, pemeriksaan = :pemeriksaan, terapi = :terapi, status = :status");
    oci_bind_by_name($query_resepsionis, ":id_dokter", $id_dokter);
    oci_bind_by_name($query_resepsionis, ":anamnesa", $anamnesa);
    oci_bind_by_name($query_resepsionis, ":diagnosis", $diagnosis);
    oci_bind_by_name($query_resepsionis, ":pemeriksaan", $pemeriksaan);
    oci_bind_by_name($query_resepsionis, ":terapi" , $terapi);
    oci_bind_by_name($query_resepsionis, ":status" , $status);

    $result_resepsionis = oci_execute($query_resepsionis);
    oci_commit($conn_resepsionis);

    oci_close($conn_resepsionis);

    // input to database pusat
    $query_pusat = oci_parse($conn_pusat, "UPDATE rekam_medis SET id_dokter = :id_dokter, anamnesa = :anamnesa, diagnosis = :diagnosis, pemeriksaan = :pemeriksaan, terapi = :terapi, status = :status");
    oci_bind_by_name($query_pusat, ":id_dokter", $id_dokter);
    oci_bind_by_name($query_pusat, ":anamnesa", $anamnesa);
    oci_bind_by_name($query_pusat, ":diagnosis", $diagnosis);
    oci_bind_by_name($query_pusat, ":pemeriksaan", $pemeriksaan);
    oci_bind_by_name($query_pusat, ":terapi" , $terapi);
    oci_bind_by_name($query_pusat, ":status" , $status);

    $result_pusat = oci_execute($query_pusat);
    oci_commit($conn_pusat);

    oci_close($conn_pusat);

    if ($result_dokter && $result_resepsionis && $result_pusat) {
      $status = "berhasil";
    }else{
      $status = "gagal";
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
                if($status == "berhasil")
                {
                  ?>
                  <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Berhasil!</strong> Pendaftaran berhasil dilakukan.
                  </div>
                  <?php
                }
                elseif($status == "gagal")
                {
                  ?>
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Gagal!</strong> Pendaftaran gagal dilakukan.
                  </div>
                  <?php
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
                      <input type="text" name="id_pasien" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Tanggal Daftar</label>
                      <input type="text" name="tgl_daftar" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Nama Pasien</label>
                      <input type="text" name="nama_pasien" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Umur</label>
                      <input type="text" name="umur" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Golongan Darah</label>
                      <input type="text" name="gol_darah" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Nama Pelayanan</label>
                      <input type="text" name="nama_pelayanan" class="form-control" readonly="true">
                    </div>
                    <div class="form-group">
                      <label>Nama Perawat</label>
                      <input type="text" name="nama_perawat" class="form-control" readonly="true">
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
                          $dokter = oci_parse($conn_lokal, $data_dokter);
                          oci_execute($dokter);

                          while (($row = oci_fetch_array($dokter, OCI_BOTH)) != false) {
                            ?><option value="<?php echo $row['ID_DOKTER']; ?>"><?php echo $row['NAMA_DOKTER']; ?></option> <?php
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
                      <label>Status</label>
                      <select class="form-control" name="status">
                        <option>-- Pilih Status --</option>
                        <option value="sudah">Sudah diperiksa</option>
                        <option value="belum">Belum diperiksa</option>
                      </select>
                      <small class="detail-form">Status pengobatan pasien. Harus diisi.</small>
                    </div>
                  </div>
                  <!-- button -->
                  <div class="btn-daftar">
                    <div class="form-group">
                      <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Daftar</button>
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
            $('input[name=nama_pasien]').val(data.item.nama_pasien);
            $('input[name=umur]').val(data.item.umur);
            $('input[name=gol_darah]').val(data.item.gol_darah);
            $('input[name=nama_pelayanan]').val(data.item.nama_pelayanan);
            $('input[name=nama_perawat]').val(data.item.nama_perawat);
          }
        })
      });
    </script>
  </body>
</html>
