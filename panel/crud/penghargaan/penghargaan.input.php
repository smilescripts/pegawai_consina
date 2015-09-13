<?php
    include_once "../../include/koneksi.php";

    
	$KODE_PENGHARGAAN = $_POST['KODE_PENGHARGAAN'];
    $NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
    $BULAN = $_POST['BULAN'];
	$TAHUN = $_POST['TAHUN'];
	$NOMINAL = $_POST['NOMINAL'];
	$TANGGAL = $_POST['TANGGAL'];
	$KETERANGAN = $_POST['KETERANGAN'];
	$state = $_POST['state'];
	
	if($state !="true") { 
		mysql_query("insert into penghargaan values(NULL,'$NIP_PEGAWAI','$BULAN','$TAHUN','$NOMINAL','$TANGGAL','$KETERANGAN')");
	}
	else{ 
		mysql_query("UPDATE `penghargaan` SET `NIP_PEGAWAI` = '$NIP_PEGAWAI',`BULAN` = '$BULAN',`TAHUN` = '$TAHUN',`NOMINAL` = '$NOMINAL',`TANGGAL` = '$TANGGAL',`KETERANGAN` = '$KETERANGAN' WHERE `KODE_PENGHARGAAN` ='$KODE_PENGHARGAAN'");
	}
	
?>
