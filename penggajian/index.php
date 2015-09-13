<?php
error_reporting(0);
		include("../panel/include/function_hitunggaji.php");

		include_once "../panel/include/koneksi.php";
		$getmachine=mysql_query("select * from mesin_absensi");
		$datamachine=mysql_fetch_object($getmachine);
		$ip=$datamachine->IP_ADDRESS;
		$port=$datamachine->PORT_COM;
		
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
	
	<!-- FormValidation -->
	<link rel="stylesheet" href="../panel/tparty/formvalidation/css/formValidation.css"/>
	
   
	<!-- Custom styles for this template -->
    <link href="../panel/bootstrap/docs/examples/theme/theme.css" rel="stylesheet">
    <link href="../panel/bootstrap/docs/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="../panel/css/absensi.css" />
	
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
				
					$("#cek").load("../panel/include/cek_koneksi_mesin.php");
					var refreshId = setInterval(function() 
					{
						$("#cek").load('../panel/include/cek_koneksi_mesin.php?randval='+ Math.random());
					}, 1000);
				});
			</script>

			<div id="cek"></div>
		</center>
		<table class="table table-bordered">
			<tr>
				<th width="50%">
					<div class="alert alert-warning fade in" role="alert"  id="penggajian-error" style="display:none;">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Perhatian!</strong> Mohon Cek Kembali NIP Anda.
					</div>
					<form method="POST" action="penggajian.data.php" class="penggajianForm" id="penggajianForm" name="penggajianForm">
						<div class="form-group" >
							<label for="exampleInputEmail1">Form Informasi Gaji Karyawan Bulan Ini</label><hr/>
							<input type="text" class="form-control" name="NIP" id="NIP" placeholder="Masukan NIP Pegawai">
						</div>
						<button type="submit" class="btn btn-default">Submit</button>
					</form>
				</th>
				<th width="50%">
					<div class="form-group">
						<label for="exampleInputEmail1">Tata Cara Cek Informasi Gaji Karyawan Bulan Ini</label><hr/>
						<ul>
							<li>Masukan NIP pegawai Pada Textfield NIP Atau Letakan Jari Pada mesin Finger Print</li>
						</ul>
						<ul>
							<li>Halaman Data Gaji Akan Tampil Setelah Memasukan atau scan jari</li>
						</ul>
					</div>

				</th>
			</tr>
		</table>
	
		<script>
						
			$(document).ready(function() {
				$('#penggajianForm')
					.on('success.form.fv', function(e) {
						//$('#penggajian-error').hide();
						e.preventDefault();
						var $form = $(e.target),
						fv    = $form.data('formValidation');
						$.ajax({
							url: $form.attr('action'),
							type: 'POST',
							data: $form.serialize(),
							success: function(data) {
								//alert(data);
								if(data=="false"){
									$('#penggajian-error').show();
									 setTimeout( function show(){
									  $('#penggajian-error').hide();
								  }, 5000 );
								}else{
									$("#data-laporan").html(data).show();
									$("#dialog-penggajian").modal("show");
								}
                          
							}
						});
					})
					.formValidation({
						message: 'This value is not valid',
						icon: {
							valid: 'glyphicon glyphicon-ok',
							invalid: 'glyphicon glyphicon-remove',
							validating: 'glyphicon glyphicon-refresh'
						},
						fields: {
							NIP: {
								validators: {
									notEmpty: {
										message: 'The value is required'
									}
								}
							},
						}
					});
				});
		</script>

		<?php if(fsockopen($ip, $port)){?>	
			
		<script>
			$(document).ready(function() {
				$("#responsecontainer").load("respone.php");
				jalan();
				$('#dialog-penggajian').on('hidden.bs.modal', function () {
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
									
								if(cek=="true"){
									var nip=data["nip"];
									document.getElementById("NIP").value = nip;
									//alert(nip);
									var ur2="penggajian.data.php";
									$.post(ur2, {NIP: nip} ,function(result) {
										$("#data-laporan").html(result).show();
										$("#dialog-penggajian").modal("show");
										window.clearInterval(refreshId); 
									});
										
								}

							}
						});
					}, 5000);
				}
			});
		</script>
		<div id="responsecontainer"></div>
		
		<?php } ?>
		
		<div class="modal fade" id="dialog-penggajian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h3 id="myModalLabel"><img alt='Brand' src='../panel/<?php echo $profil->logo; ?>' style='width:50px; height:50px;'/>&nbsp;&nbsp;&nbsp;Data Gaji</h3>
					</div>
					<div class="modal-body">
						<div id="data-laporan" name="data-laporan" class="data-laporan"></div>
					</div>
				</div>
			</div>
		</div>
    </div> 
	<!-- /container -->


	<footer class="footer">
		<div class="container">
            <p class="pull-right"><a style="color:<?php echo $profil->COLOR; ?>" href="#"><span class="glyphicon glyphicon-triangle-top"></span> Back to top <span class="glyphicon glyphicon-triangle-top"></span></a></p>
            <p class="text-muted">&copy; <?php echo date('Y');?>  - <a href="" style="color:<?php echo $profil->COLOR; ?>"><?php echo $profil->NAMA_PERUSAHAAN; ?></a> - All Rights Reserved. </p>
		</div>
    </footer>
	
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.4/jquery-ui.js"></script>
	
	 <script type="text/javascript" src="../panel/tparty/formvalidation/js/formValidation.js"></script>
    <script type="text/javascript" src="../panel/tparty/formvalidation/js/framework/bootstrap.js"></script>
	
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
    <!-- IE12 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../panel/bootstrap/docs/assets/js/ie12-viewport-bug-workaround.js"></script>
	
    <!-- data tables -->
  
</body>
</html>