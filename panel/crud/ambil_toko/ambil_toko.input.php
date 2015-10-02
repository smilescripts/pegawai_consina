<?php
    include_once "../../include/koneksi.php";
    session_start();
    
    if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM ambil_toko WHERE KODE_AMBIL=".$_POST['hapus']);
    } else {
		$KODE_AMBIL = $_POST['KODE_AMBIL'];
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
		$TANGGAL = $_POST['TANGGAL'];
        $NOMINAL = $_POST['NOMINAL'];
        $KETERANGAN = $_POST['KETERANGAN'];
        $STATUS = $_POST['STATUS'];
        $PTG = $_SESSION['KODE_PETUGAS'];
		$before=mysql_fetch_object(mysql_query("SELECT * FROM ambil_toko where KODE_AMBIL='$KODE_AMBIL'"));
	
		
		if($KODE_AMBIL == 0) {
            mysql_query("INSERT INTO ambil_toko 
							VALUES(NULL,'$NIP_PEGAWAI','$TANGGAL','$NOMINAL','$KETERANGAN','Hutang','$PTG')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan Input pengambilan barang toko :".$NIP_PEGAWAI." dengan nominal sebesar:".$NOMINAL."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE ambil_toko SET NIP_PEGAWAI = '$NIP_PEGAWAI',TANGGAL = '$TANGGAL',"
                    . "NOMINAL = '$NOMINAL',KETERANGAN = '$KETERANGAN',STATUS = '$STATUS',KODE_PETUGAS = '$PTG' "
                    . "WHERE KODE_AMBIL = '$KODE_AMBIL' ");
					include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data pengambilan barang toko :".$NIP_PEGAWAI." dari nominal ".$before->NOMINAL." menjadi:".$NOMINAL."";
			catat($user,$aksi);
		}
    }
?>