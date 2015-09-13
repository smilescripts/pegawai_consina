<style>
	.blink_me {
		-webkit-animation-name: blinker;
		-webkit-animation-duration: 1s;
		-webkit-animation-timing-function: linear;
		-webkit-animation-iteration-count: infinite;

		-moz-animation-name: blinker;
		-moz-animation-duration: 1s;
		-moz-animation-timing-function: linear;
		-moz-animation-iteration-count: infinite;

		animation-name: blinker;
		animation-duration: 1s;
		animation-timing-function: linear;
		animation-iteration-count: infinite;
	}

	@-moz-keyframes blinker {  
		0% { opacity: 1.0; }
		50% { opacity: 0.0; }
		100% { opacity: 1.0; }
	}

	@-webkit-keyframes blinker {  
		0% { opacity: 1.0; }
		50% { opacity: 0.0; }
		100% { opacity: 1.0; }
	}

	@keyframes blinker {  
		0% { opacity: 1.0; }
		50% { opacity: 0.0; }
		100% { opacity: 1.0; }
	}
</style>	
		
<?php
	error_reporting(0);
	include_once "koneksi.php";
	$ip=$_SERVER['REMOTE_ADDR'];
	$getmachine=mysql_query("select * from mesin_absensi where MAC_ADDRESS='$ip'");
	$datamachine=mysql_fetch_object($getmachine);
	$ip=$datamachine->IP_ADDRESS;
	$port=$datamachine->PORT_COM;
	
	if(!fsockopen($ip, $port)){?>
	<div class="alert alert-danger"  style="width: 760px;"" role="alert"><h3><b><span class="blink_me">Peringatan Koneksi Mesin Finger Print Tidak Terhubung !!!</span></b></h3></div>
	<audio controls autoplay style="display:none">
		<source src="../panel/include/97744^ALARM.mp3" type="audio/mpeg">
	</audio>
		
<?php } ?>