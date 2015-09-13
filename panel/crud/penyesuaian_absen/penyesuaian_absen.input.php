<?php
    include_once "../../include/koneksi.php";
	session_start();
	$state_session=$_SESSION['STATE_ID'];
    
	if(isset($_POST['hapus'])) {
			
		$query=mysql_query("SELECT * FROM detail_penyesuaian_absensi WHERE HEAD_ID_PENYESUAIAN='".$_POST['hapus']."'") or die (mysql_error());
        while($objectdata=mysql_fetch_object($query)){
			mysql_query("DELETE FROM absensi WHERE TANGGAL='".$objectdata->TANGGAL."' AND NIP_PEGAWAI='".$objectdata->KODE_PEGAWAI."'");
		}
		
		mysql_query("DELETE FROM detail_penyesuaian_absensi WHERE HEAD_ID_PENYESUAIAN=".$_POST['hapus']);
		mysql_query("DELETE FROM penyesuaian_absensi WHERE ID=".$_POST['hapus']);
    } 
	else {
		$ID = $_POST['ID'];
		$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
		$BULAN = $_POST['BULAN'];
		$TAHUN = $_POST['TAHUN'];
		$TANGGAL_AKSES = date('Y-m-d H:i:s');
		$KODE_PETUGAS = $_SESSION['KODE_PETUGAS'];

	
		//$before=mysql_fetch_object(mysql_query("SELECT * FROM penyesuaian_absensi where ID='$ID'"));
	
		if($ID == 0) {
            mysql_query("INSERT INTO penyesuaian_absensi VALUES(NULL,'$KODE_PEGAWAI','$BULAN','$TAHUN','$TANGGAL_AKSES','$KODE_PETUGAS')");
			$HEAD_ID_PENYESUAIAN=mysql_insert_id();
			
			/* foreach($_POST["TANGGAL"] as $key=>$value){
				$JAM_MASUK=$_POST["JAM_MASUK"][$key];	
				$JAM_KELUAR=$_POST["JAM_KELUAR"][$key];	
				mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK','$JAM_KELUAR','$value','$KODE_PEGAWAI')");
			} */
			
			/* foreach($_POST["TANGGAL"] as $key1=>$value1){
				$JAM_MASUK1=$_POST["JAM_MASUK"][$key1];	
				$JAM_KELUAR1=$_POST["JAM_KELUAR"][$key1];
				
				$qcekab=mysql_query("select * from absensi where NIP_PEGAWAI='$KODE_PEGAWAI' AND TANGGAL='$value1' AND JAM_MASUK='00:00:00' OR JAM_KELUAR='00:00:00'");
				$tcekab=mysql_num_rows($qcekab);
				
				if($tcekab>0){
					mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK1','$JAM_KELUAR1','$value1','$KODE_PEGAWAI')");
					mysql_query("update absensi set JAM_MASUK='$JAM_MASUK1',JAM_KELUAR='$JAM_KELUAR1' where TANGGAL='$value1' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
				}else{
					mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK1','$JAM_KELUAR1','$value1','$KODE_PEGAWAI')");
					mysql_query("
						INSERT INTO `absensi` (`KODE_ABSENSI`, `KODE_JAM_KERJA`, `NIP_PEGAWAI`, `TANGGAL`, `JAM_MASUK`, `JAM_KELUAR`, `TELAT`) VALUES (NULL, '1', '$KODE_PEGAWAI', '$value1', '$JAM_MASUK1', '$JAM_KELUAR1', '0');
					");
				}
				
			} */
			
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan tambah data penyesuaian absensi pegawai :".$KODE_PEGAWAI ;
			catat($user,$aksi);
		} else {
            mysql_query("UPDATE penyesuaian_absensi SET JUMLAH_PENYESUAIAN_ABSEN = '$JUMLAH_PENYESUAIAN_ABSEN'  WHERE ID = '$ID' ");
	
			include "../../include/catat.php";
			$user=$_SESSION['KODE_PETUGAS'];
			$aksi="Melakukan ubah data penyesuaian absensi pegawai :".$KODE_PEGAWAI." dengan jumlah penyesuaian awal :".$before->JUMLAH_PENYESUAIAN_ABSEN." tanggal, menjadi ".$JUMLAH_PENYESUAIAN_ABSEN." tanggal";
			catat($user,$aksi);
		}
    }
?>
