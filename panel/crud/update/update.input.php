<?php
	$zip = new ZipArchive;
	
	if ($zip->open('system_update.zip') === TRUE) {
		$zip->extractTo("../../../");
		$zip->close();
		echo 'ok';
		include "../../include/koneksi.php";
		include "../../include/catat.php";
		$user=$_SESSION['KODE_PETUGAS'];
		$aksi="Berhasil melakukan proses pembaruan sistem";
		catat($user,$aksi);
	} else {
		echo 'failed';
	}
?>