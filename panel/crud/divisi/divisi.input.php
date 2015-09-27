<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM divisi WHERE ID=".$_POST['hapus']);
    } else {
		$ID = $_POST['ID'];
		$NAMA = $_POST['NAMA'];
		$KODE_DEPARTEMEN = $_POST['KODE_DEPARTEMEN'];
	
		$before=mysql_fetch_object(mysql_query("SELECT * FROM divisi where ID='$ID'"));
	
		if($ID == 0) {
            mysql_query("INSERT INTO divisi VALUES(NULL,'$NAMA','$KODE_DEPARTEMEN')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data divisi :".$NAMA."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE divisi SET NAMA = '$NAMA', KODE_DEPARTEMEN = '$KODE_DEPARTEMEN' WHERE ID = '$ID' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data divisi ".$before->NAMA." Menjadi ".$NAMA."";
			catat($user,$aksi);
		}
    }
?>
