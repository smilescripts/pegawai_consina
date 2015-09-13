<?php
	error_reporting(0);
	include_once "../../include/koneksi.php";
	session_start();
	$BULAN = $_GET["bulan"];
	$TAHUN = $_GET["tahun"];

	
	$pengaturan = mysql_fetch_array(mysql_query("SELECT VALUE FROM pengaturan_penggajian WHERE ID='9'"));
	$data = mysql_fetch_array(mysql_query("SELECT kode_penggajian,DATE_ADD(tanggal_gaji,INTERVAL ".$pengaturan['VALUE']." DAY) AS cktgl FROM head_penggajian WHERE bulan='$BULAN' AND tahun='$TAHUN'"));
	
	//Prints the result
	if ($data["kode_penggajian"]=="") {
		$dtck="<span class='green'>Bulan Dan Tahun tersedia</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'yes','dtck'=>$dtck));
	}
	else{
		$datenow=date("Y-m-d");
		if($data["cktgl"]>=$datenow){
			$dtck="<span class='green'>Bulan Dan Tahun tersedia</span>";
			header('Content-Type: application/json');
			echo json_encode(array('verifikasi' => 'yes','dtck'=>$dtck));
		}else{
			$dtck="<span class='red'>Bulan Dan Tahun Sudah Dilakukan Penggajian</span>";
			header('Content-Type: application/json');
			echo json_encode(array('verifikasi' => 'no','dtck'=>$dtck));
		}
	}
?>