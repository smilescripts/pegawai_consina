<?php
	error_reporting(0);
	include_once "../../include/koneksi.php";
	session_start();
	$nip = $_GET["nip"];
	$TANGGAL = $_GET["tanggal"];
	$tglnya=strtotime($TANGGAL);
	$tmptgl=date('Y-m',$tglnya);
	$BULAN = $_GET["bulan"];
	$BULAN = $_GET["bulan"];
	$TAHUN = $_GET["tahun"];
	$Awal = new DateTime($TAHUN.'-'.$BULAN);
	$ckck=$Awal->format('Y-m');
	
	//if($tmptgl==$ckck){
		$data = mysql_fetch_array(mysql_query("SELECT * FROM absensi WHERE TANGGAL='$TANGGAL' and NIP_PEGAWAI='$nip'"));
		if ($data["KODE_ABSENSI"]=="") {
			$dtck="<span class='green'>Tanggal tersedia</span>";
			header('Content-Type: application/json');
			echo json_encode(array('verifikasi' => 'yes','dtck'=>$dtck));
		}
		else{
				if($data['JAM_MASUK']=='00:00:00' or $data['JAM_KELUAR']=='00:00:00'){
					$dtck="<span class='green'>Tanggal tersedia</span>";
					header('Content-Type: application/json');
					echo json_encode(array('verifikasi' => 'yes','dtck'=>$dtck));
				}else{
					$dtck="<span class='red'>Maaf Tanggal Absensi Sudah Ada </span>";
					header('Content-Type: application/json');
					echo json_encode(array('verifikasi' => 'no','dtck'=>$dtck));
				}
		}
	/* }else{
		$dtck="<span class='red'>Maaf Tanggal Bulan Dan Tahun Tidak Sesuai</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'no','dtck'=>$dtck));
	} */
?>