<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
		$before1=mysql_fetch_object(mysql_query("SELECT * FROM detail_penyesuaian_absensi where ID_DETAIL_PENYESUAIAN=".$_POST['hapus']));
		$tmptgl=$before1->TANGGAL;
		$tmpkpeg=$before1->KODE_PEGAWAI;
		mysql_query("DELETE FROM absensi WHERE TANGGAL='$tmptgl' and NIP_PEGAWAI='$tmpkpeg'");
		mysql_query("DELETE FROM detail_penyesuaian_absensi WHERE ID_DETAIL_PENYESUAIAN=".$_POST['hapus']);
		
		include "../../include/catat.php";
		$user=$_SESSION['KODE_PETUGAS'];
		$aksi="Melakukan hapus data detail penyesuaian absensi pegawai :".$tmpkpeg." tanggal :".$tmptgl;
		catat($user,$aksi);
    } else {
		$ID_DETAIL_PENYESUAIAN = $_POST['ID_DETAIL_PENYESUAIAN'];
		$HEAD_ID_PENYESUAIAN = $_POST['HEAD_ID_PENYESUAIAN'];
		$JAM_MASUK = $_POST['JAM_MASUK'];
		$JAM_KELUAR = $_POST['JAM_KELUAR'];
		$TANGGAL = $_POST['TANGGAL'];
		$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
	
		if($ID_DETAIL_PENYESUAIAN == 0) {
			mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK','$JAM_KELUAR','$TANGGAL','$KODE_PEGAWAI')");
			$data56 = mysql_fetch_array(mysql_query("SELECT * FROM absensi where TANGGAL='$TANGGAL' and NIP_PEGAWAI='$KODE_PEGAWAI'"));
			if ($data56["KODE_ABSENSI"]=="") {
				mysql_query("
					INSERT INTO `absensi` (`KODE_ABSENSI`, `KODE_JAM_KERJA`, `NIP_PEGAWAI`, `TANGGAL`, `JAM_MASUK`, `JAM_KELUAR`, `TELAT`) VALUES (NULL, '1', '$KODE_PEGAWAI', '$TANGGAL', '$JAM_MASUK', '$JAM_KELUAR', '0');
				");
			}else{
				mysql_query("update absensi set JAM_MASUK='$JAM_MASUK',JAM_KELUAR='$JAM_KELUAR',TANGGAL='$TANGGAL' where TANGGAL='$TANGGAL' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
			}
			
			
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data detail penyesuaian absensi pegawai :".$KODE_PEGAWAI." tanggal :".$TANGGAL;
			catat($user,$aksi);
		} else {
			$before=mysql_fetch_object(mysql_query("SELECT * FROM detail_penyesuaian_absensi where ID_DETAIL_PENYESUAIAN='$ID_DETAIL_PENYESUAIAN'"));
            mysql_query("update detail_penyesuaian_absensi set JAM_MASUK='$JAM_MASUK',JAM_KELUAR='$JAM_KELUAR',TANGGAL='$TANGGAL' where ID_DETAIL_PENYESUAIAN='$ID_DETAIL_PENYESUAIAN'");
			mysql_query("update absensi set JAM_MASUK='$JAM_MASUK',JAM_KELUAR='$JAM_KELUAR',TANGGAL='$TANGGAL' where TANGGAL='$before->TANGGAL' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
			
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data detail penyesuaian absensi pegawai :".$KODE_PEGAWAI;
			catat($user,$aksi);
		}
    }
?>
