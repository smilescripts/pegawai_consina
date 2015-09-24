<?php
    include_once "../../include/koneksi.php";

    
	$ID = $_POST['ID'];
	$TAHUN = $_POST['TAHUN'];
	$BULAN = $_POST['BULAN'];
	$SENIN = implode(",",$_POST['SENIN']);
	$SELASA = implode(",",$_POST['SELASA']);
	$RABU = implode(",",$_POST['RABU']);
	$KAMIS = implode(",",$_POST['KAMIS']);
	
	
	 if($ID==0) { 
		mysql_query("insert into libur_outlet_perbln values(NULL,'$SENIN','$SELASA','$RABU','$KAMIS','$BULAN','$TAHUN')");
	}
	else{ 
		mysql_query("UPDATE `libur_outlet_perbln` SET `SENIN` = '$SENIN',`BULAN` = '$BULAN',`TAHUN` = '$TAHUN',
						`SELASA` = '$SELASA', `RABU` = '$RABU', `KAMIS` = '$KAMIS' WHERE `ID` ='$ID'");
	} 
	
?>
