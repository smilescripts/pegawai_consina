<?php
	error_reporting(0);
	include_once "../panel/include/koneksi.php";
		
	$ip=$_SERVER['REMOTE_ADDR'];
	$mac_string = shell_exec("arp -a $ip");
	$mac_array = explode(" ",$mac_string);
	$mac = $mac_array[3];
		
	$getmachine=mysql_query("select * from mesin_absensi where MAC_ADDRESS='$ip'");
	$datamachine=mysql_fetch_object($getmachine);
	$ip=$datamachine->IP_ADDRESS;
	$port=$datamachine->PORT_COM;
	if(!fsockopen($ip, $port)){?>
		<div class="alert alert-danger" style="width: 760px;" role="alert">Peringatan Koneksi Mesin Finger Print Tidak Terhubung !!!</div>
	<?php } ?>	