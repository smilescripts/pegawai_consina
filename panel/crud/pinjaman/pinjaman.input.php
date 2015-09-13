<?php
    include_once "../../include/koneksi.php";
    session_start();
    
    if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM kasbon_pegawai WHERE KODE_KASBON=".$_POST['hapus']);
    } else {
		$KODE_KASBON = $_POST['KODE_KASBON'];
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
		$TANGGAL = $_POST['TANGGAL'];
        $NOMINAL = $_POST['NOMINAL'];
        $KETERANGAN = $_POST['KETERANGAN'];
        $STATUS = $_POST['STATUS'];
        $PTG = $_SESSION['KODE_PETUGAS'];
		$before=mysql_fetch_object(mysql_query("SELECT * FROM kasbon_pegawai where KODE_KASBON='$KODE_KASBON'"));
	
		
		if($KODE_KASBON == 0) {
            mysql_query("INSERT INTO kasbon_pegawai 
							VALUES(NULL,'$NIP_PEGAWAI','$TANGGAL','$NOMINAL','$KETERANGAN','Hutang','$PTG')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan Input Kasbon pegawai :".$NIP_PEGAWAI." dengan nominal sebesar:".$NOMINAL."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE kasbon_pegawai SET NIP_PEGAWAI = '$NIP_PEGAWAI',TANGGAL = '$TANGGAL',"
                    . "NOMINAL = '$NOMINAL',KETERANGAN = '$KETERANGAN',STATUS = '$STATUS',KODE_PETUGAS = '$PTG' "
                    . "WHERE KODE_KASBON = '$KODE_KASBON' ");
					include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data kasbon pegawai :".$NIP_PEGAWAI." dari nominal ".$before->NOMINAL." menjadi:".$NOMINAL."";
			catat($user,$aksi);
		}
    }
?>