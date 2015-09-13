<?php
    include_once "../../include/koneksi.php";
    session_start();
    
    if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM absensi WHERE KODE_ABSENSI=".$_POST['hapus']);
    } else {
		$KODE_ABSENSI = $_POST['KODE_ABSENSI'];
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
        $TANGGAL = $_POST['TANGGAL'];
        $JAM_MASUK = $_POST['JAM_MASUK'];
        $JAM_KELUAR = $_POST['JAM_KELUAR'];
        
        $tmp=$JAM_MASUK;
        $timestamp = strtotime($tmp) + 60*60*2;
        $tmpmasuk = date('H:i:s', $timestamp);
        $KODE_JAM_KERJA=0;
        $queryjam=mysql_query("SELECT * FROM jam_kerja");
        
		while($tampiljam = mysql_fetch_object($queryjam)){
            $JAM_DATANG=$tampiljam->JAM_DATANG;
            $JAM_PULANG=$tampiljam->JAM_PULANG;
            
            if($tmpmasuk>=$JAM_DATANG AND $tmpmasuk<=$JAM_PULANG){
                $KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
            }
            if($tmpmasuk>=$JAM_DATANG AND $tmpmasuk>=$JAM_PULANG){
                $KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
            }
        }

		if($KODE_ABSENSI == 0) {
			mysql_query("INSERT INTO absensi 
			VALUES(NULL,'$KODE_JAM_KERJA','$NIP_PEGAWAI','$TANGGAL','$JAM_MASUK','$JAM_KELUAR')");
		} else {
			mysql_query("UPDATE absensi SET KODE_JAM_KERJA = '$KODE_JAM_KERJA',NIP_PEGAWAI = '$NIP_PEGAWAI',"
						. "TANGGAL = '$TANGGAL',JAM_MASUK = '$JAM_MASUK',JAM_KELUAR = '$JAM_KELUAR' "
						. "WHERE KODE_ABSENSI = '$KODE_ABSENSI' ");
		}
	}
?>