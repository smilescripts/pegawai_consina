<?php
	include_once "../panel/include/koneksi.php";
	error_reporting(0);
	$NIP2=$_POST['NIP'];
	$getNIP=mysql_query("select * from pegawai where NIP_PEGAWAI='$NIP2'");
	$dataNIP=mysql_fetch_object($getNIP);
	$cekNIP=mysql_num_rows($getNIP);
	
	
	
	if($cekNIP>0){
		if($dataNIP->STATUS_PEGAWAI=="Kontrak"){
			include("penggajian.dataharian.php");
		}else{
			include("penggajian.databulanan.php");
		}
		
?>
	

<?php 
	} else{
		echo 'false';
	}
?>