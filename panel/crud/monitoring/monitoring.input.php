<?php
    include_once "../../include/koneksi.php";

   
	$KODE_MESIN = $_POST['KODE_MESIN'];
	$NAMA_MESIN = $_POST['NAMA_MESIN'];
	$IP_ADDRESS = $_POST['IP_ADDRESS'];
	$PORT_COM = $_POST['PORT_COM'];
	
	mysql_query("UPDATE mesin_absensi SET NAMA_MESIN = '$NAMA_MESIN',IP_ADDRESS = '$IP_ADDRESS',PORT_COM = '$PORT_COM'  WHERE KODE_MESIN = '$KODE_MESIN' ");
	
   
?>
