<?php
    include_once "include/koneksi.php";
    include_once "include/catat.php";
    session_start();
    error_reporting(0);
    if(!isset($_SESSION['KODE_PETUGAS'])){
		echo"<script>alert('Lakukan Login Terlebih Dahulu');window.location='index.php'</script>";
    }
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
    <link rel="icon" href="<?php echo $profil->logo; ?>">

    <title><?php echo $profil->NAMA_PERUSAHAAN; ?></title>
	
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/docs/dist/css/bootstrap.min.css" rel="stylesheet">
	 <!-- Bootstrap theme -->
    <link href="bootstrap/docs/dist/css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="bootstrap/docs/dist/css/bootstrap.min.php" rel="stylesheet">
	<link href="bootstrap/docs/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
	<script src="bootstrap/docs/dist/css/jquery-2.1.4.min.js"></script>
	<script src="bootstrap/docs/dist/css/bootstrap-colorpicker.js"></script>
	<script src="bootstrap/docs/dist/css/docs.js"></script>
    <!-- JQuery -->
     <!-- <script src="js/jquery-1.11.1.min.js"></script>-->
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
	
    <!-- datatables -->
    <link href="tparty/datatables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="tparty/datatables/dataTables.colVis.css" rel="stylesheet" />
	
	
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="tparty/datepicker/css/bootstrap-datepicker3.css" />
    <script src="tparty/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="tparty/datepicker/js/bootstrap-datepicker.min.js"></script>
    
     <!-- timepicker -->
    <link rel="stylesheet" type="text/css" href="tparty/timepicker/bootstrap-timepicker.min.css" />
    <script src="tparty/timepicker/bootstrap-timepicker.js"></script>
	
	
    <!-- FormValidation -->
    <link rel="stylesheet" href="tparty/formvalidation/css/formValidation.css"/>
	
    <!-- Select2 -->
    <!-- Include Select2 CSS -->
    <link rel="stylesheet" href="tparty/select2/select2.min.css" />

    <!-- CSS to make Select2 fit in with Bootstrap 3.x -->
    <link rel="stylesheet" href="tparty/select2/select2-bootstrap.min.css" />
    <script src="tparty/select2/select2.min.js"></script>

   
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Custom styles for this template -->
    <link href="bootstrap/docs/examples/theme/theme.css" rel="stylesheet">
    <link href="bootstrap/docs/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/backend.php" />
	
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
                    <td class="col-sm-1" rowspan="2"><img alt="Brand" src="<?php echo $profil->logo; ?>" style="width:75px; height:75;"/></td>
                    <td class="col-sm-12" style="border-bottom:1pt solid green;">
                        <h3 style="color:<?php echo $profil->COLOR; ?>;"><?php echo $profil->NAMA_PERUSAHAAN; ?></h3>
                    </td>
				</tr>
				<tr>
				
                    <td class="col-sm-12">
                        <h4 style="color:<?php echo $profil->COLOR; ?>;">Online Sistem Penggajian Dan Absensi Karyawan</h4>
                    </td>
				</tr>
				<!--<div class="clock" style="position:absolute;margin-left:870px;margin-top:20px;
                font:bold 12px Arial, Helvetica, sans-serif;
                color:#bbbbbb;background:#202020;">
                
                <ul style="width:300px; margin:0 auto; padding:0px; list-style:none; text-align:center; ">
					<li style=" display:inline; font-size:5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="hours"> </li>
					<li style=" display:inline; font-size:5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="point">:</li>
					<li style=" display:inline; font-size:5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="min"> </li>
					<li style=" display:inline; font-size:5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="point">:</li>
					<li style=" display:inline; font-size:5em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff;" id="sec"> </li>
				</ul>

			</div>-->
            </table>
			
        </div>
		<div id="data-menu" class="data-menu"></div>	
    </nav>	


    <div class="container theme-showcase" role="main">
		<div class="col-md-12">
		<noscript>
		<center>
				<p><div class="alert alert-danger" role="alert"><b>Peringatan:Silahkan Aktifkan Fitur Javascript Pada Browser Anda, Untuk Dapat Mengakses Web Ini</b></div></p>
		</center>	
		</noscript>
            <div id="data-utama" class="data-utama"></div>
		</div>
    </div> <!-- /container -->
	
    <footer class="footer">
		<div class="container">
            <p class="pull-right"><a href="#"><span class="glyphicon glyphicon-triangle-top"></span>Kembali Ke Atas<span class="glyphicon glyphicon-triangle-top"></span></a></p>
			<p class="text-muted">&copy; <?php echo date('Y');?>  - <a href=""><?php echo $profil->NAMA_PERUSAHAAN; ?></a> - All Rights Reserved. </p>
		</div>
    </footer>
	
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="crud/menu/aplikasi.js"></script>

	<!-- bootstrap -->
    <script src="bootstrap/docs/dist/js/bootstrap.min.js"></script>
	 	<script src="js/timer.js"></script>
	 <!-- datepicker -->
    <script src="tparty/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="tparty/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="tparty/datepicker/js/bootstrap-datepicker.id.min.js"></script>
	 
	 <!-- formvalidation -->
    <script type="text/javascript" src="tparty/formvalidation/js/formValidation.js"></script>
    <script type="text/javascript" src="tparty/formvalidation/js/framework/bootstrap.js"></script>

    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="bootstrap/docs/assets/js/vendor/holder.js"></script>
    <script src="bootstrap/docs/assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
	
    <!-- data tables -->
    <script src="tparty/datatables/jquery.dataTables.js"></script>
    <script src="tparty/datatables/dataTables.tableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="tparty/datatables/dataTables.bootstrap.js"></script>
    <script src="tparty/datatables/dataTables.colVis.js"></script>
	
</body>
</html>