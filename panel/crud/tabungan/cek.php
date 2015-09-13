<?php
	$NOMINAL_PENGAMBILAN=$_GET["NOMINAL_PENGAMBILAN"];
	$NOMINAL_TABUNGAN=$_GET["NOMINAL_TABUNGAN"];
	
	if ($NOMINAL_PENGAMBILAN > 25000) {
		echo "<span class='red'>Nominal pengambilan tidak bisa lebih besar dari total tabungan</span>";
	}
	else{
		echo "<span class='green'>Nominal pengambilan disetujui</span>";
		header('Content-Type: application/json');
		echo json_encode(array('verifikasi' => 'yes'));
	}
		
?>