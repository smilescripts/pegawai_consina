<?php

	function catat($user,$aksi){
		$tanggal=date('Y-m-d H:i:s');
		$ip=$_SERVER["REMOTE_ADDR"];
		$hostname=gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		$useragent=$_SERVER["HTTP_USER_AGENT"];
		mysql_query("INSERT INTO `user_log_activity` (`id` ,`kode_petugas` ,`aktivitas` ,`waktu`,`ip_address` ,`hostname` ,`user_agent`)
		VALUES (NULL ,  '$user',  '$aksi',  '$tanggal',  '$ip',  '$hostname',  '$useragent')");
	}
?>