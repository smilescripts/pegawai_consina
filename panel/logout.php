<?php
    session_start();

    session_destroy();

    header('location:index.php');
	include "include/koneksi.php";
	include "include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan keluar sistem";
	catat($user,$aksi);

?>
