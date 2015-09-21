<?php
    include_once "../../include/koneksi.php";

    
	$ID = $_POST['ID'];
	$TAHUN = $_POST['TAHUN'];
	$BULAN = $_POST['BULAN'];
	$TANGGAL = $_POST['TANGGAL'];
	$state = $_POST['state'];
	
	if($state !="true") { 
		mysql_query("insert into hari_libur_outlet values(NULL,'$BULAN','$TAHUN','$TANGGAL')");
	}
	else{ 
		mysql_query("UPDATE `hari_libur_outlet` SET `TANGGAL` = '$TANGGAL',`BULAN` = '$BULAN',`TAHUN` = '$TAHUN' WHERE `ID` ='$ID'");
	}
	
?>
