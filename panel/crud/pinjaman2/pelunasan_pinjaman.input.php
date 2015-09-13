<?php
    include_once "../../include/koneksi.php";
    session_start();
    
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
		$NOMINAL_PEMBAYARAN = $_POST['NOMINAL_PEMBAYARAN'];
		$ANGSURAN_KE ="Pelunasan";
		$ID_PINJAMAN = $_POST['ID_PINJAMAN'];
        $TANGGAL_PEMBAYARAN = date('Y-m-d H:i:s');
        $PETUGAS = $_SESSION['KODE_PETUGAS'];
		mysql_query("INSERT INTO pembayaran_angsuran 
		VALUES(NULL,'$NIP_PEGAWAI','$NOMINAL_PEMBAYARAN','$ANGSURAN_KE','$TANGGAL_PEMBAYARAN','$PETUGAS','$ID_PINJAMAN')");
		
		include "../../include/catat.php";
		$user=$_SESSION['KODE_PETUGAS'];
		$aksi="Melakukan pelunasan pinjaman pegawai :".$NIP_PEGAWAI." dengan nominal sebesar:".$NOMINAL_PEMBAYARAN." pada cicilan ke-".$ANGSURAN_KE."";
		catat($user,$aksi);
		
		$pinjaman=mysql_query("select * from pinjaman where KODE_PINJAMAN='$ID_PINJAMAN'");
		$getpinjaman=mysql_fetch_object($pinjaman);
		$nominalpinjaman=$getpinjaman->CICILAN_PERBULAN;
		$sisa_cicilan=0;
		mysql_query("UPDATE `pinjaman` SET `SISA_CICILAN` = '$sisa_cicilan' WHERE KODE_PINJAMAN='$ID_PINJAMAN'");
	
   
?>