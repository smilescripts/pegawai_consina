<?php
    include_once "../../include/koneksi.php";

    if(isset($_POST['hapus'])) {
	mysql_query("DELETE FROM departemen WHERE KODE_DEPARTEMEN=".$_POST['hapus']);
    } else {
	$NAMA_DEPARTEMEN = $_POST['NAMA_DEPARTEMEN'];
	$KODE_DEPARTEMEN = $_POST['KODE_DEPARTEMEN'];
	
	if($KODE_DEPARTEMEN == 0) {
            mysql_query("INSERT INTO departemen VALUES(NULL,'$NAMA_DEPARTEMEN')");
	} else {
            mysql_query("UPDATE departemen SET NAMA_DEPARTEMEN = '$NAMA_DEPARTEMEN'  WHERE KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' ");
	}
    }
?>
