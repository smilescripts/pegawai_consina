<?php
	error_reporting(0);
	include_once "../../include/koneksi.php";
	session_start();
	$uname = $_GET["uname"];

	$data = mysql_fetch_array(mysql_query("SELECT NIP_PEGAWAI FROM pegawai WHERE NIP_PEGAWAI='$uname'"));
  
	
	//Prints the result
	if ($data["NIP_PEGAWAI"]=="") {
		echo "<span class='green'>NIP tersedia</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'yes'));
	}
	else{
		echo "<span class='red'>NIP sudah terdaftar</span>";
	}
?>