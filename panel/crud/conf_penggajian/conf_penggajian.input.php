<?php
	error_reporting(0);
    include_once "../../include/koneksi.php";
	$ID = $_POST['ID'];
	
	if($ID=="2"){ 
		$VALUE = $_POST['VALUE'];
		$VALUE1 = $_POST['VALUE1'];
		$get=$VALUE.','.$VALUE1;
		mysql_query("UPDATE pengaturan_penggajian SET VALUE = '$get'  WHERE ID = '$ID' ");
	
	}
	if($ID!="2"){ 
		$VALUE = $_POST['VALUE'];
		mysql_query("UPDATE pengaturan_penggajian SET VALUE = '$VALUE'  WHERE ID = '$ID' ");
	
	}
?>
