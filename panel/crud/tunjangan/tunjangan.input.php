<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM master_tunjangan WHERE KODE_MASTER_TUNJANGAN=".$_POST['hapus']);
    } else {
		$KODE_MASTER_TUNJANGAN = $_POST['KODE_MASTER_TUNJANGAN'];
		$NAMA_TUNJANGAN = $_POST['NAMA_TUNJANGAN'];
		$NOMINAL = $_POST['NOMINAL'];
		$before=mysql_fetch_object(mysql_query("SELECT * FROM master_tunjangan where KODE_MASTER_TUNJANGAN='$KODE_MASTER_TUNJANGAN'"));
	
	
		if($KODE_MASTER_TUNJANGAN == 0) {
            mysql_query("INSERT INTO master_tunjangan 
			VALUES(NULL,'$NAMA_TUNJANGAN','$NOMINAL','$state_session')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data tunjangan :".$NAMA_TUNJANGAN." dengan Nominal jabatan :".$NOMINAL." ";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE master_tunjangan SET NAMA_TUNJANGAN = '$NAMA_TUNJANGAN',NOMINAL = '$NOMINAL'  WHERE KODE_MASTER_TUNJANGAN = '$KODE_MASTER_TUNJANGAN' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data tunjangan :".$before->NAMA_TUNJANGAN." menjadi :".$NAMA_TUNJANGAN." dengan Nominal jabatan :".$before->NOMINAL."->".$NOMINAL."";
			catat($user,$aksi);
		}
    }
?>