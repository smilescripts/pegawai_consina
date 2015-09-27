<?php
include_once "../../include/koneksi.php";
$jabatan = $_POST['jabatan'];
$result = mysql_query("select * from jabatan where KODE_DIVISI='$jabatan'");  
echo '<option value="">Silahkan Pilih Jabatan</option>';  
while ($row = mysql_fetch_array($result)) {
	echo '<option value="' . $row['KODE_JABATAN'] . '">' . $row['NAMA_JABATAN']. '</option>';  
}  
?>
