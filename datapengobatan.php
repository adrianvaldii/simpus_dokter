<?php
  error_reporting(0);
  // connect to database lokal
  include_once 'koneksi/koneksi_lokal.php';
  // connect to database pusat
  include_once 'koneksi/koneksi_pusat.php';
  // connect to database resepsionis
  include_once 'koneksi/koneksi_resepsionis.php';

  // sql
  $sql_lokal = "select * from rekam_medis";
  $sql_lokal_resepsionis = "select d.id_daftar, d.tgl_daftar, d.id_pasien, r.nama_pasien, r.umur, r.gol_darah, p.nama_pelayanan, pr.nama_perawat from rekam_medis d join pasien@to_resepsionis r on d.id_pasien = r.id_pasien join pelayanan@to_resepsionis p on d.id_pelayanan = p.id_pelayanan join perawat@to_resepsionis pr on d.id_perawat = pr.id_perawat";
  $sql_lokal_pusat = "select d.id_daftar, d.tgl_daftar, d.id_pasien, r.nama_pasien, r.umur, r.gol_darah, p.nama_pelayanan, pr.nama_perawat from rekam_medis d join pasien@to_pusat r on d.id_pasien = r.id_pasien join pelayanan@to_pusat p on d.id_pelayanan = p.id_pelayanan join perawat@to_pusat pr on d.id_perawat = pr.id_perawat";
  $sql_pusat = "select d.id_daftar, d.tgl_daftar, d.id_pasien, r.nama_pasien, r.umur, r.gol_darah, p.nama_pelayanan, pr.nama_perawat from rekam_medis d join pasien r on d.id_pasien = r.id_pasien join pelayanan p on d.id_pelayanan = p.id_pelayanan join perawat pr on d.id_perawat = pr.id_perawat";
  $sql_resepsionis = "select d.id_daftar, d.tgl_daftar, d.id_pasien, r.nama_pasien, r.umur, r.gol_darah, p.nama_pelayanan, pr.nama_perawat from rekam_medis d join pasien r on d.id_pasien = r.id_pasien join pelayanan p on d.id_pelayanan = p.id_pelayanan join perawat pr on d.id_perawat = pr.id_perawat";

  // logika basis data terdistribusi id rekam_medis
  if ($status_lokal == "ON" && $status_resepsionis == "ON") {
    // eksekusi lokal, resepsionis
    $data_lokal_resepsionis = oci_parse($conn_lokal, $sql_lokal_resepsionis);
    oci_execute($data_lokal_resepsionis);

    while ($data = oci_fetch_array($data_lokal_resepsionis, OCI_BOTH)) {
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

  } elseif ($status_lokal == "ON" && $status_pusat == "ON") {
    // eksekusi lokal, pusat
    $data_lokal_pusat = oci_parse($conn_lokal, $sql_lokal_pusat);
    oci_execute($data_lokal_pusat);

    while ($data = oci_fetch_array($data_lokal_pusat, OCI_BOTH)) {
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

  } elseif ($status_lokal == "ON" && $status_pusat == "OFF" && $status_resepsionis == "OFF") {
    // eksekusi lokal
    $data_lokal = oci_parse($conn_lokal, $sql_lokal);
    oci_execute($data_lokal);

    while ($data = oci_fetch_array($data_lokal, OCI_BOTH)) {
      $row['value'] = $data['ID_DAFTAR'];
      $row_set[] = $row;
    }

    echo json_encode($row_set);

  } elseif ($status_lokal == "OFF" && $status_pusat == "ON") {
    // eksekusi pusat
    $data_pusat = oci_parse($conn_pusat, $sql_pusat);
    oci_execute($data_pusat);

    while ($data = oci_fetch_array($data_pusat, OCI_BOTH)) {
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

  } elseif ($status_lokal == "OFF" && $status_resepsionis == "ON") {
    // eksekusi lokal, resepsionis
    $data_resepsionis = oci_parse($conn_resepsionis, $sql_resepsionis);
    oci_execute($data_resepsionis);

    while ($data = oci_fetch_array($data_resepsionis, OCI_BOTH)) {
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

  }
?>
