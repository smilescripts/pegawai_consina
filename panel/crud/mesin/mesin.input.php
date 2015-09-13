<?php
    include_once "../../include/koneksi.php";

   
	$KODE_MESIN = $_POST['KODE_MESIN'];
	$NAMA_MESIN = $_POST['NAMA_MESIN'];
	$IP_ADDRESS = $_POST['IP_ADDRESS'];
	$PORT_COM = $_POST['PORT_COM'];
	$MAC_ADDRESS = $_POST['MAC_ADDRESS'];
	if($KODE_MESIN == 0) {
		mysql_query("INSERT INTO mesin_absensi VALUES(NULL,'$NAMA_MESIN','$IP_ADDRESS','$PORT_COM','$MAC_ADDRESS')");
	}else{
		mysql_query("UPDATE mesin_absensi SET NAMA_MESIN = '$NAMA_MESIN',IP_ADDRESS = '$IP_ADDRESS',PORT_COM = '$PORT_COM',MAC_ADDRESS = '$MAC_ADDRESS'  WHERE KODE_MESIN = '$KODE_MESIN' ");
	}
	
	
   
?>
