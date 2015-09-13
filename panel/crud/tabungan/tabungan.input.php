<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
   
	$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
	$ID_PETUGAS = $_SESSION['KODE_PETUGAS'];
	$TANGGAL_PENGAMBILAN = $_POST['TANGGAL_PENGAMBILAN'];
	$NOMINAL_PENGAMBILAN = $_POST['NOMINAL_PENGAMBILAN'];
	$KETERANGAN = $_POST['KETERANGAN'];
	
	

    mysql_query("INSERT INTO pengambilan_tabungan VALUES(NULL,'$NIP_PEGAWAI','$ID_PETUGAS','$TANGGAL_PENGAMBILAN','$NOMINAL_PENGAMBILAN','$KETERANGAN')");
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan pengambilan tabungan pegawai :".$NIP_PEGAWAI." dengan nominal sebesar ".$NOMINAL_PENGAMBILAN."";
	catat($user,$aksi);
          
?>
