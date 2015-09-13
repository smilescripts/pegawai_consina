<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
   
	$ID = $_POST['ID'];
	$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
	$JUMLAH_PENYESUAIAN_ABSEN = $_POST['JUMLAH_PENYESUAIAN_ABSEN'];
	$TANGGAL_AKSES = date('Y-m-d H:i:s');
	$KODE_PETUGAS = $_SESSION['KODE_PETUGAS'];

	mysql_query("UPDATE penyesuaian_absensi SET KODE_PEGAWAI = '$KODE_PEGAWAI'  WHERE ID = '$ID'");
	
	foreach($_POST["ID_DETAIL_PENYESUAIAN"] as $key=>$value){
		$TANGGAL=$_POST["TANGGAL"][$key];	
		$JAM_MASUK=$_POST["JAM_MASUK"][$key];	
		$JAM_KELUAR=$_POST["JAM_KELUAR"][$key];	
		mysql_query("update detail_penyesuaian_absensi set JAM_MASUK='$JAM_MASUK',JAM_KELUAR='$JAM_KELUAR',TANGGAL='$TANGGAL' where ID_DETAIL_PENYESUAIAN='$value'");
	}
			
	foreach($_POST["ID_DETAIL_PENYESUAIAN"] as $key1=>$value1){
		$TANGGAL1=$_POST["TANGGAL"][$key1];	
		$JAM_MASUK1=$_POST["JAM_MASUK"][$key1];	
		$JAM_KELUAR1=$_POST["JAM_KELUAR"][$key1];
		/* $qcekab=mysql_query("select * from absensi where NIP_PEGAWAI='$KODE_PEGAWAI' AND TANGGAL='$TANGGAL1' AND JAM_MASUK='00:00:00' OR JAM_KELUAR='00:00:00'");
		$tcekab=mysql_num_rows($qcekab);
		
		if($tcekab>0){
			mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK1','$JAM_KELUAR1','$TANGGAL1','$KODE_PEGAWAI')");
			mysql_query("update absensi set JAM_MASUK='$JAM_MASUK1',JAM_KELUAR='$JAM_KELUAR1' where TANGGAL='$TANGGAL1' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
		}else{
			mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK1','$JAM_KELUAR1','$TANGGAL1','$KODE_PEGAWAI')");
			mysql_query("
				INSERT INTO `absensi` (`KODE_ABSENSI`, `KODE_JAM_KERJA`, `NIP_PEGAWAI`, `TANGGAL`, `JAM_MASUK`, `JAM_KELUAR`, `TELAT`) VALUES (NULL, '1', '$KODE_PEGAWAI', '$TANGGAL1', '$JAM_MASUK1', '$JAM_KELUAR1', '0');
			");
		} */
		
		mysql_query("update absensi set JAM_MASUK='$JAM_MASUK1',JAM_KELUAR='$JAM_KELUAR1',TANGGAL='$TANGGAL1' where TANGGAL='$TANGGAL1' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
	}
	
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan ubah data penyesuaian absensi pegawai :".$KODE_PEGAWAI."";
	catat($user,$aksi);
	
?>
