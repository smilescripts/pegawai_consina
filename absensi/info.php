<style>
	.chart-wrapper {
		position: relative;
		padding-bottom: 40%;
	}

	.chart-inner {
		position: absolute;
		width: 100%; height: 100%;
	}

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
	include_once "../panel/include/koneksi.php";
	error_reporting(0);
	$NIP1=$_GET["NIP"];
	$get=mysql_query("select * from pegawai where KODE_PEGAWAI='$NIP1'");
	$view=mysql_fetch_object($get);
	$NIP2=$view->NIP_PEGAWAI;
?>

<script>
	$(function () {
		$('#container2').highcharts({
			chart: {
				type: 'bar'
			},
			title: {
				text: 'Grafik Kehadiran'
			},
			subtitle: {
				text: 'Source: Wikipedia.org'
			},
			xAxis: {
				categories: [
					<?php
						$tahunskr=date("Y");
						$absensidatag=mysql_query("SELECT * FROM absensi  where YEAR(TANGGAL)='$tahunskr' and NIP_PEGAWAI='$view->KODE_PEGAWAI' GROUP BY MONTH(TANGGAL) ORDER BY MONTH(TANGGAL)") or die (mysql_error());
						while($getabsensidatag=mysql_fetch_object($absensidatag)){
							$tglnya=strtotime($getabsensidatag->TANGGAL);
							$BULAN2=date('m',$tglnya);
							
							if($BULAN2=="01"){$namabulan1="Januari";}
							if($BULAN2=="02"){$namabulan1="Februari";}
							if($BULAN2=="03"){$namabulan1="Maret";}
							if($BULAN2=="04"){$namabulan1="April";}
							if($BULAN2=="05"){$namabulan1="Mei";}
							if($BULAN2=="06"){$namabulan1="Juni";}
							if($BULAN2=="07"){$namabulan1="Juli";}
							if($BULAN2=="08"){$namabulan1="Agustus";}
							if($BULAN2=="09"){$namabulan1="September";}
							if($BULAN2=="10"){$namabulan1="Oktober";}
							if($BULAN2=="11"){$namabulan1="November";}
							if($BULAN2=="12"){$namabulan1="Desember";} 
							
							echo "'".$namabulan1."',";
						}
					?>
				],
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Absensi',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' hari'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 100,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [{
				name: "<?php echo $view->NAMA_PEGAWAI; ?>",
				data: [
					<?php
						$tahunskr=date("Y");
						$absensidatag=mysql_query("SELECT * FROM absensi  where YEAR(TANGGAL)='$tahunskr' and NIP_PEGAWAI='$view->KODE_PEGAWAI' GROUP BY MONTH(TANGGAL) ORDER BY MONTH(TANGGAL)") or die (mysql_error());
						while($getabsensidatag=mysql_fetch_object($absensidatag)){
							$absensidatag1=mysql_query("SELECT COUNT(KODE_ABSENSI) AS jmlper FROM absensi where MONTH(TANGGAL)=MONTH('$getabsensidatag->TANGGAL') and YEAR(TANGGAL)='$tahunskr' and NIP_PEGAWAI='$view->KODE_PEGAWAI'") or die (mysql_error());
							$getabsensidatag1=mysql_fetch_object($absensidatag1);
							echo $getabsensidatag1->jmlper.",";
						}
					?>
				]
			}, ]
		});
		var chart = $('#container2').highcharts();
		$('#dialog-info').on('show.bs.modal', function() {
			$('#container2').css('visibility', 'hidden');
		});
		$('#dialog-info').on('shown.bs.modal', function() {
			$('#container2').css('visibility', 'initial');
			chart.reflow();
		});   
	});
</script>
					
<div class="modal-body">
	<div class="row">
		<div class="col-md-6">
			<?php
				if($view->STATUS_PEGAWAI=="Kontrak"){
					include("penggajian.dataharian.php");
				}else{
					include("penggajian.databulanan.php");
				}
			?>
		</div>
		<div class="col-md-6">
			<div class="well">
				<div id="container2" style="height:350px;"></div>
			</div>
		</div>
		<div class="col-md-12">		  
			<?php if($cek>15){ ?>
				<div class="alert alert-danger"  style="width: 100%;"" role="alert"><center>
					<h5><b><span class="blink_me">Harap Tingkatkan Ketepatan Waktu Anda!!! (<span style="color:blue;">TerLlambar : <?php echo $terlambat; ?></span>)</span></b></h5>
				</center></div>
			<?php } ?>
		</div>
	</div>
</div>