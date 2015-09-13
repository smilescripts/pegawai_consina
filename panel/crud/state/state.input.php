<?php
	session_start();
    include_once "../../include/koneksi.php";
	
    if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM state WHERE STATE_ID=".$_POST['hapus']);
    } else {
		$STATE_ID = $_POST['STATE_ID'];
		$STATE_NAME = $_POST['STATE_NAME'];
		$before=mysql_fetch_object(mysql_query("SELECT * FROM state where STATE_ID='$STATE_ID'"));
		
		if($STATE_ID == 0) {
            mysql_query("INSERT INTO state VALUES(NULL,'$STATE_NAME')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data lokasi ".$STATE_NAME."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE state SET STATE_NAME = '$STATE_NAME'  WHERE STATE_ID = '$STATE_ID' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data lokasi ".$before->STATE_NAME." menjadi ".$STATE_NAME."";
			catat($user,$aksi);
		}
    }
?>
