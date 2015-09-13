<?php
    include_once "../../include/koneksi.php";
    session_start();
    
    if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM pinjaman WHERE KODE_PINJAMAN=".$_POST['hapus']);
    } else {
		$KODE_PINJAMAN = $_POST['KODE_PINJAMAN'];
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
		$TANGGAL = $_POST['TANGGAL'];
        $NOMINAL = $_POST['NOMINAL'];
        $JUMLAH_BLN = $_POST['JUMLAH_BLN'];
        $KETERANGAN = $_POST['KETERANGAN'];
        $STATUS = $_POST['STATUS'];
        $PTG = $_SESSION['KODE_PETUGAS'];
		$CICILAN_PERBULAN=$NOMINAL/$JUMLAH_BLN;
		$before=mysql_fetch_object(mysql_query("SELECT * FROM pinjaman where KODE_PINJAMAN='$KODE_PINJAMAN'"));
	
		if($KODE_PINJAMAN == 0) {
            mysql_query("INSERT INTO pinjaman 
						VALUES(NULL,'$NIP_PEGAWAI','$TANGGAL','$NOMINAL','$JUMLAH_BLN','$KETERANGAN','Hutang','$PTG','$CICILAN_PERBULAN','$JUMLAH_BLN')");
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan Input pinjaman pegawai :".$NIP_PEGAWAI." dengan nominal sebesar:".$NOMINAL." dicicil selama ".$JUMLAH_BLN." bulan/".$CICILAN_PERBULAN."";
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE pinjaman SET KODE_PEGAWAI = '$NIP_PEGAWAI',TANGGAL = '$TANGGAL',"
                    . "NOMINAL = '$NOMINAL',JUMLAH_BLN = '$JUMLAH_BLN',KETERANGAN = '$KETERANGAN',STATUS = '$STATUS',KODE_PETUGAS = '$PTG',CICILAN_PERBULAN = '$CICILAN_PERBULAN' "
                    . "WHERE KODE_PINJAMAN = '$KODE_PINJAMAN' ");
						include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data pinjaman pegawai :".$NIP_PEGAWAI." dengan nominal sebesar:".$NOMINAL." dicicil selama ".$JUMLAH_BLN." bulan/".$CICILAN_PERBULAN." dengan data sebelumnya ".$before->NOMINAL."/".$before->JUMLAH_BLN."  ";
			catat($user,$aksi);
		}
    }
?>