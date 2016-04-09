<?php
  // connect to database oracle lokal
  include 'koneksi/koneksi_lokal.php';

  $sql = "SELECT * FROM pasien";
  $datapasien = oci_parse($conn_lokal, $sql);
  oci_execute($datapasien);

  while ($data = oci_fetch_array($datapasien, OCI_BOTH)) {
    $row['value'] = $data['ID_PASIEN'];
    $row['nama_pasien'] = $data['NAMA_PASIEN'];
    $row['nama_ortu'] = $data['NAMA_ORTU'];
    $row['jenis_kelamin'] = $data['JENIS_KELAMIN'];
    $row['tempat_lahir'] = $data['TEMPAT_LAHIR'];
    $row['tgl_lahir'] = date("d F Y", strtotime($data['TGL_LAHIR']));
    $row['umur'] = $data['UMUR'];
    $row['alamat_asal'] = $data['ALAMAT_ASAL'];
    $row['alamat_domisili'] = $data['ALAMAT_DOMISILI'];
    $row['pekerjaan'] = $data['PEKERJAAN'];
    $row['telp'] = $data['TELP'];
    $row['gol_darah'] = $data['GOL_DARAH'];
    $row_set[] = $row;
  }

  echo json_encode($row_set);

?>
