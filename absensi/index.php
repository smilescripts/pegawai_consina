<?php  
	error_reporting(0);
	include_once "../panel/include/koneksi.php";

	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../panel/<?php echo $profil->logo; ?>">

    <title><?php echo $profil->NAMA_PERUSAHAAN; ?></title>
	
    <!-- Bootstrap core CSS -->
    <link href="../panel/bootstrap/docs/dist/css/bootstrap.min.css" rel="stylesheet">
	 <!-- Bootstrap theme -->
    <link href="../panel/bootstrap/docs/dist/css/bootstrap-theme.min.css" rel="stylesheet">
	
    <!-- JQuery -->
    <script src="../panel/js/jquery-1.11.1.min.js"></script>
    <script src="../panel/js/jquery-migrate-1.2.1.min.js"></script>
	
   
	<!-- Custom styles for this template -->
    <link href="../panel/bootstrap/docs/examples/theme/theme.css" rel="stylesheet">
    <link href="../panel/bootstrap/docs/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../panel/css/absensi.php" />
	
  </head>
  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-custom  navbar-fixed-top" style="background-image: linear-gradient(to bottom, #E8E8E8 0px, #F5F5F5 100%);
	background-repeat: repeat-x;
	border-color: #DCDCDC;
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05) inset, 0px 1px 0px rgba(255, 255, 255, 0.1);">
        <div class="container">
            <table width="100%">
                <tr>
                    <td class="col-sm-1" rowspan="2"><img alt="Brand" src="../panel/<?php echo $profil->logo; ?>" style="width:75px; height:75;"/></td>
                    <td class="col-sm-12" style="border-bottom:1pt solid green;">
                        <h3 style="color:<?php echo $profil->COLOR; ?>;"><?php echo $profil->NAMA_PERUSAHAAN; ?></h3>
                    </td>
				</tr>
				<tr>
                    <td class="col-sm-12">
                        <h4 style="color:<?php echo $profil->COLOR; ?>;">Online Sistem Penggajian Dan Absensi Karyawan</h4>
                    </td>
				</tr>
            </table>
        </div>
    </nav>	

    <div class="container theme-showcase" role="main">
		<center>
			<script>
				$(document).ready(function() {
					/* var ur2="info.php";
					$("#isi-info").load(ur2);
					$("#dialog-info").modal("show"); */
					
					$("#cek").load("../panel/include/cek_koneksi_mesin.php");
					var refreshId = setInterval(function() 
					{
						$("#cek").load('../panel/include/cek_koneksi_mesin.php?randval='+ Math.random());
					}, 60000);
                });
			</script>

			<div id="cek"></div>

			<?php
				include_once "../panel/include/koneksi.php";
				$getmachine=mysql_query("select * from mesin_absensi");
				$datamachine=mysql_fetch_object($getmachine);
				$ip=$datamachine->IP_ADDRESS;
				$port=$datamachine->PORT_COM;
			?>
		</center>
        <div class="container" style="width: 960px; margin: 0 auto; overflow: hidden;display:block">
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
			<hr/>
			<h4>Tata cara absensi</h4>
			<ul>
				<li>Silahkan taruh jari yang telah didaftarkan pada mesin fingerprint</li>
				<li>Tunggu sampai proses verifikasi jari anda terverifikasi </li>
				<li>Setelah terverifikasi maka anda telah melakukan absensi</li>
			</ul>
		</div>

		<?php if(fsockopen($ip, $port)){?>			
			<script>
				$(document).ready(function() {
					$("#responsecontainer").load("respone.php");
					jalan();
					$('#dialog-info').on('hidden.bs.modal', function () {
						jalan();
					});
					
					function jalan(){
						var refreshId = setInterval(function() 
						{
							$.ajax({
								url: "respone.php",
								type: 'POST',
								data: "",
								dataType: "json",
								success: function(data) {
									var cek=data["cek"];
									var nip=data["nip"];
									if(cek=="true"){
										//alert(nip);
										var ur2="info.php?NIP="+nip;
										$("#isi-info").load(ur2);
										//$("#dialog-info").modal("show");
										//window.clearInterval(refreshId);
										//setTimeout( function show(){
											//$("#dialog-info").modal("hide");
										//}, 5000 );
									}
								}
							});
							//$("#responsecontainer").load('respone.php?randval='+ Math.random());
	  
						}, 5000);
					}
				});
			</script>

			<div id="responsecontainer"></div>
		<?php } ?>

		<div class="modal fade" id="dialog-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="myModalLabel"><img alt='Brand' src='../panel/<?php echo $profil->logo; ?>' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Informasi Pegawai</h3>
					</div>

					<div id="isi-info" name="isi-info" class="isi-info"></div>
				</div>
			</div>
		</div>   
    </div> <!-- /container -->

	
	<footer class="footer">
		<div class="container">
            <p class="pull-right"><a href="#" style="color:<?php echo $profil->COLOR; ?>;"><span class="glyphicon glyphicon-triangle-top"></span> Back to top <span class="glyphicon glyphicon-triangle-top"></span></a></p>
            <p class="text-muted" style="color:<?php echo $profil->COLOR; ?>;">&copy; 2015  - <a href="" >Consina</a> - All Rights Reserved. </p>
		</div>
    </footer>
	
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
	
	<!-- bootstrap -->
    <script src="../panel/bootstrap/docs/dist/js/bootstrap.min.js"></script>
	<script src="../panel/tparty/hightchart/highcharts.js"></script>
	<script src="../panel/tparty/hightchart/highcharts-3d.js"></script>
	<script src="../panel/tparty/hightchart/exporting.js"></script>
	<script src="../panel/js/timer.js"></script>
	 <!-- datepicker -->
    <!-- formvalidation -->
   <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../panel/bootstrap/docs/assets/js/vendor/holder.js"></script>
    <script src="../panel/bootstrap/docs/assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../panel/bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
	
    <!-- data tables -->
  
 </body>
</html>