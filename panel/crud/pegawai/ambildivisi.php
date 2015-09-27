<?php
include_once "../../include/koneksi.php";
$divisi = $_POST['divisi'];
$result = mysql_query("select * from divisi where KODE_DEPARTEMEN='$divisi'");  
echo '<option value="">Silahkan Pilih Divisi</option>';  
while ($row = mysql_fetch_array($result)) {
	echo '<option value="' . $row['ID'] . '">' . $row['NAMA']. '</option>';  
}  
?>
