<?php
    session_start();
	include_once "../../include/koneksi.php";
	$state_session=$_POST['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM petugas WHERE KODE_PETUGAS=".$_POST['hapus']);
    } else {
		$KODE_PETUGAS = $_POST['KODE_PETUGAS'];
		$NAMA_PETUGAS = $_POST['NAMA_PETUGAS'];
		$EMAIL = $_POST['EMAIL'];
		$USERNAME_LOGIN = $_POST['USERNAME_LOGIN'];
		$PASSWORD_LOGIN = $_POST['PASSWORD_LOGIN'];
		$AKSES = $_POST['AKSES'];
		
		if($KODE_PETUGAS == 0) {
            mysql_query("INSERT INTO petugas VALUES(NULL,'$NAMA_PETUGAS','$EMAIL','$USERNAME_LOGIN','$PASSWORD_LOGIN','$state_session','$AKSES')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data petugas :".$NAMA_PETUGAS."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE petugas SET NAMA_PETUGAS = '$NAMA_PETUGAS',EMAIL = '$EMAIL',USERNAME_LOGIN = '$USERNAME_LOGIN',PASSWORD_LOGIN = '$PASSWORD_LOGIN',STATE_ID = '$state_session',AKSES = '$AKSES'  WHERE KODE_PETUGAS = '$KODE_PETUGAS' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data petugas :".$KODE_PETUGAS."";
			catat($user,$aksi);
		}
    }
?>
