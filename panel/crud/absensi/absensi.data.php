<?php

// panggil berkas koneksi.php
	include_once "../../include/koneksi.php";
	session_start();
	$getmachine=mysql_query("select * from mesin_absensi");
	$datamachine=mysql_fetch_object($getmachine);
	$ip=$datamachine->IP_ADDRESS;
	$port=$datamachine->PORT_COM;
?>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
		"sDom": 'C<"top"flt>rt<"bottom"ip><"clear">',
        //responsive: true
    } );
} );
</script>


<style type="text/css">


@font-face {
    font-family: 'BebasNeueRegular';
    src: url('BebasNeue-webfont.eot');
    src: url('BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
         url('BebasNeue-webfont.woff') format('woff'),
         url('BebasNeue-webfont.ttf') format('truetype'),
         url('BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;

}

.clock {width:800px; margin:0 auto; padding:30px; border:1px solid #333; color:#fff; }

#Date { font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; font-size:36px; text-align:center; text-shadow:0 0 5px #00c6ff; }


#point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:10px; padding-right:10px; }

@-webkit-keyframes mymove 
{
	0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
	50% {opacity:0; text-shadow:none; }
	100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}


@-moz-keyframes mymove 
{
	0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
	50% {opacity:0; text-shadow:none; }
	100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}

</style>
<script type="text/javascript">
	$(document).ready(function() {
		// Create two variable with the names of the months and days in an array
		var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
		var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

		// Create a newDate() object
		var newDate = new Date();
		// Extract the current date from Date object
		newDate.setDate(newDate.getDate());
		// Output the day, date, month and year    
		$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

		setInterval( function() {
			// Create a newDate() object and extract the seconds of the current time on the visitor's
			var seconds = new Date().getSeconds();
			// Add a leading zero to seconds value
			$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);
	
		setInterval( function() {
			// Create a newDate() object and extract the minutes of the current time on the visitor's
			var minutes = new Date().getMinutes();
			// Add a leading zero to the minutes value
			$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
		},1000);
	
		setInterval( function() {
			// Create a newDate() object and extract the hours of the current time on the visitor's
			var hours = new Date().getHours();
			// Add a leading zero to the hours value
			$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
		}, 1000);
	
	}); 
</script>

<div class="container" style="width: 960px; margin: 0 auto; overflow: hidden;">
	<center>
		<script>
			$(document).ready(function() {
				$("#cek").load("../panel/include/cek_koneksi_mesin.php");
				var refreshId = setInterval(function() 
				{
					$("#cek").load('../panel/include/cek_koneksi_mesin.php?randval='+ Math.random());
				}, 1000);
			});
		</script>

		<div id="cek"></div>
	</center>
	
	<div class="clock" style="border-radius:20px;background:#202020;
		font:bold 12px Arial, Helvetica, sans-serif;
		color:#bbbbbb; ">
		<div id="Date"></div>
		<ul style="width:800px; margin:0 auto; padding:0px; list-style:none; text-align:center; ">
			<li style=" display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="hours"> </li>
			<li style=" display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="point">:</li>
			<li style=" display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="min"> </li>
			<li style=" display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="point">:</li>
			<li style=" display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="sec"> </li>
		</ul>
	</div>
</div>
<hr/>
<h4>Tata Cara Absensi</h4>
<ul>
	<li>Silahkan Taruh Jari Yang telah didaftarkan Pada Mesin Fingerprint</li>
	<li>Tunggu sampai proses verifikasi jari anda terverifikasi </li>
	<li>Setelah Terverifikasi Maka Anda telah melakukan Absensi</li>
</ul>
	
<?php if(fsockopen($ip, $port)){?>			
<script>
	$(document).ready(function() {
		$("#responsecontainer").load("respone.php");
		var refreshId = setInterval(function() 
		{
			$("#responsecontainer").load('respone.php?randval='+ Math.random());
		}, 5000);
    });
</script>

<div id="responsecontainer"></div>
<?php } ?>