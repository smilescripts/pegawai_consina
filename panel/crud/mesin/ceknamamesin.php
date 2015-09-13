<?php
	error_reporting(0);
	include_once "../../include/koneksi.php";
	session_start();
	$uname = $_GET["uname"];

	$data = mysql_fetch_array(mysql_query("SELECT NAMA_MESIN FROM mesin_absensi WHERE NAMA_MESIN='$uname'"));
  
	
	//Prints the result
	if ($data["NAMA_MESIN"]=="") {
		echo "<span class='green'>Nama mesin tersedia</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'yes'));
	}
	else{
		echo "<span class='red'>Nama mesin Sudah digunakan</span>";

	}
?>