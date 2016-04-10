<?php
  // connect to database oracle lokal
  include 'koneksi/koneksi_lokal.php';

  $sql = "select d.id_daftar, d.tgl_daftar, d.id_pasien, r.nama_pasien, r.umur, r.gol_darah, p.nama_pelayanan, pr.nama_perawat from rekam_medis d join pasien@to_resepsionis r on d.id_pasien = r.id_pasien join pelayanan@to_resepsionis p on d.id_pelayanan = p.id_pelayanan join perawat@to_resepsionis pr on d.id_perawat = pr.id_perawat";
  $datapengobatan = oci_parse($conn_lokal, $sql);
  oci_execute($datapengobatan);

  while ($data = oci_fetch_array($datapengobatan, OCI_BOTH)) {
    $row['value'] = $data['ID_DAFTAR'];
    $row['tgl_daftar'] = date("d F Y", strtotime($data['TGL_DAFTAR']));
    $row['id_pasien'] = $data['ID_PASIEN'];
    $row['nama_pasien'] = $data['NAMA_PASIEN'];
    $row['umur'] = $data['UMUR'];
    $row['gol_darah'] = $data['GOL_DARAH'];
    $row['nama_pelayanan'] = $data['NAMA_PELAYANAN'];
    $row['nama_perawat'] = $data['NAMA_PERAWAT'];
    $row_set[] = $row;
  }

  echo json_encode($row_set);
  // print_r(json_encode($row_set));die();
?>
