<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM penyesuaian_dana WHERE KODE_penyesuaian_dana=".$_POST['hapus']);
    } else {
		$ID_PENYESUAIAN = $_POST['ID_PENYESUAIAN'];
		$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
		$STATUS = $_POST['STATUS'];
		$NOMINAL = $_POST['NOMINAL'];
		$BULAN = $_POST['BULAN'];
		$KETERANGAN = $_POST['KETERANGAN'];
		$TANGGAL_INPUT = date('Y-m-d H:i:s');
		
		$before=mysql_fetch_object(mysql_query("SELECT * FROM penyesuaian_dana where ID_PENYESUAIAN='$ID_PENYESUAIAN'"));
	
		if($ID_PENYESUAIAN == 0) {
            mysql_query("INSERT INTO penyesuaian_dana 
			VALUES(NULL,'$KODE_PEGAWAI','$STATUS','$NOMINAL','$BULAN','$KETERANGAN','$TANGGAL_INPUT')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data penyesuaian_dana :".$KODE_PEGAWAI." dengan Nominal penyesuaian_dana :".$NOMINAL." ";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE penyesuaian_dana SET KODE_PEGAWAI ='$KODE_PEGAWAI',STATUS='$STATUS',NOMINAL='$NOMINAL',BULAN ='$BULAN',KETERANGAN = '$KETERANGAN' WHERE ID_PENYESUAIAN = '$ID_PENYESUAIAN' ");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data penyesuaian_dana :".$before->KODE_PEGAWAI." menjadi :".$KODE_PEGAWAI." dengan Nominal penyesuaian_dana :".$before->NOMINAL."->".$NOMINAL."";
			catat($user,$aksi);
		}
    }
?>