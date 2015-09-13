<?php
	error_reporting(0);
	include_once "../../include/koneksi.php";
	session_start();
	$uname = $_GET["uname"];

	$data = mysql_fetch_array(mysql_query("SELECT USERNAME_LOGIN FROM petugas WHERE USERNAME_LOGIN='$uname'"));
	  
		
	//Prints the result
	if ($data["USERNAME_LOGIN"]=="") {
		echo "<span class='green'>Username tersedia</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'yes'));
	}
	else{
		echo "<span class='red'>Username Sudah digunakan</span>";
	}
?>