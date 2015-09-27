<?php
	session_start();
	error_reporting(0);
    include_once "../../include/koneksi.php";
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman utama sistem";
	catat($user,$aksi);
?>
<script src="modul/mod_laporan_gaji/highcharts.js" type="text/javascript"></script>
<script src="modul/mod_laporan_gaji/exporting.js" type="text/javascript"></script>
<ol class="breadcrumb">
  <li class="active">Beranda</li>
</ol>

<div class="row" style="border:1">
    <div class="col-md-12">
   <div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Grafik Penggajian</h3>
    </div>
    <div class="panel-body">
	<div style="padding: 10px 10px 10px;">
          
	</div>
	<div class="well">
    <script>
	var chart1; // globally available
	$(document).ready(function() {
	
      chart1 = new Highcharts.Chart({
        chart: {
			renderTo: 'container4',
            type: 'line'
        },
	
        title: {
            text: 'Grafik Penggajian'
        },
        subtitle: {
            text: 'Perbulan'
        },
		
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
			
            title: {
                text: 'Jumlah'
            }
			
			
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 formatter: function () {
                            return Highcharts.numberFormat(this.y,0);
                     }
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Penggajian',
            data: [
				<?php
					$tahun=date("Y");
					for($x=1; $x<=12; $x++){
						if($x<10){
							$tampil=mysql_fetch_object(mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as jumlah_gaji FROM head_penggajian  where bulan='0".$x."' and tahun='$tahun'"));
						}else{
							$tampil=mysql_fetch_object(mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as jumlah_gaji FROM head_penggajian where bulan='$x' and tahun='$tahun'"));
						}
						if($tampil->jumlah_gaji!=""){
							$getjumlah=$tampil->jumlah_gaji;
							$number=number_format($getjumlah,0,'','');
							$replace=str_replace(',','',$number);
							
							echo "$getjumlah,";
						}else{
							echo "0,";
						}
					}
				?>
			]
        }]
    });
});
   
   
   var chart2; // globally available
	$(document).ready(function() {
	
      chart2 = new Highcharts.Chart({
        chart: {
			renderTo: 'container22',
            type: 'line'
        },
	
        title: {
            text: 'Grafik Kasbon'
        },
        subtitle: {
            text: 'Perbulan'
        },
		
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
			
            title: {
                text: 'Jumlah'
            }
			
			
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 formatter: function () {
                            return Highcharts.numberFormat(this.y,0);
                     }
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Kasbon',
            data: [
				<?php
					$tahun=date("Y");
					for($x=1; $x<=12; $x++){
						if($x<10){
							$tampil=mysql_fetch_object(mysql_query("SELECT sum(kasbon) as jumlahkasbon FROM head_penggajian where bulan='0".$x."' and tahun='$tahun'"));
						}else{
							$tampil=mysql_fetch_object(mysql_query("SELECT sum(kasbon) as jumlahkasbon FROM head_penggajian where bulan='$x' and tahun='$tahun'"));
						}
						if($tampil->jumlahkasbon!=""){
							$getjumlah=$tampil->jumlahkasbon;
							echo "$getjumlah,";
						}else{
							echo "0,";
						}
					}
				?>
			]
        }]
    });
});
   
   var chart3; // globally available
		$(document).ready(function() {
	
      chart3 = new Highcharts.Chart({
        chart: {
			renderTo: 'container23',
            type: 'line'
        },
	
        title: {
            text: 'Grafik Peminjaman'
        },
        subtitle: {
            text: 'Perbulan'
        },
		
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
			
            title: {
                text: 'Jumlah'
            }
			
			
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 formatter: function () {
                            return Highcharts.numberFormat(this.y,0);
                     }
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Peminjaman',
            data: [
				<?php
					$tahun=date("Y");
					for($x=1; $x<=12; $x++){
						if($x<10){
							$tampil=mysql_fetch_object(mysql_query("SELECT sum(pinjaman) as jumlahpinjaman FROM head_penggajian where bulan='0".$x."' and tahun='$tahun'"));
						}else{
							$tampil=mysql_fetch_object(mysql_query("SELECT sum(pinjaman) as jumlahpinjaman FROM head_penggajian where bulan='$x' and tahun='$tahun'"));
						}
						if($tampil->jumlahpinjaman!=""){
							$getjumlah=$tampil->jumlahpinjaman;
							echo "$getjumlah,";
						}else{
							echo "0,";
						}
					}
				?>
			]
        }]
    });
});
   

</script>
<div style="overflow-y:scroll;height:940px">
<div id="container4" style="height: 400px"></div>
<hr/>
<div id="container22" style="height: 400px"></div>
<hr/>
<div id="container23" style="height: 400px"></div>
</div>
	
	
	
	</div>
    </div>
	</div>
  
  </div>  
  
  <div class="col-md-4">
  <div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Pembayaran Pinjaman karyawan  
    </div>
    <div class="panel-body">
	<div style="padding: 10px 10px 10px;">
          
	</div>
	<div class="well">
	<div style="overflow-y:scroll;height:100px">
             <?php
            $grouppinjaman=mysql_query("SELECT tanggal_gaji,sum(pinjaman) as totpinjaman from `head_penggajian` group by bulan") or die (mysql_error());
            $no = 1;
            while($objectgrouppinjaman=mysql_fetch_object($grouppinjaman)){
			$bulanpinjaman=date('F Y', strtotime($objectgrouppinjaman->tanggal_gaji));
			
			
			echo'
			<p>'.$bulanpinjaman.': Rp.<b>'.number_format($objectgrouppinjaman->totpinjaman).'</b></p>';}
				if($bulanpinjaman==""){
				echo '<h4>Tidak ditemukan data pinjaman</h4>';
				
			}
			?>
	</div>
	</div>
    </div>
	</div>
	</div>
  <div class="col-md-4">
   <div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Pembayaran Kasbon karyawan</h3>
    </div>
    <div class="panel-body">
	<div style="padding: 10px 10px 10px;">
          
	</div>
	<div class="well">
	<div style="overflow-y:scroll;height:100px">
            <?php
            $groupkasbon=mysql_query("SELECT tanggal_gaji,sum(kasbon) as totkasbon from `head_penggajian` group by bulan") or die (mysql_error());
            $no = 1;
            while($objectgroupkasbonn=mysql_fetch_object($groupkasbon)){
			$bulankasbon=date('F Y', strtotime($objectgroupkasbonn->tanggal_gaji));
			echo'
			<p>'.$bulankasbon.': Rp.<b>'.number_format($objectgroupkasbonn->totkasbon).'</b></p>
			
			';
			
			}
			if($bulankasbon==""){
				echo '<h4>Tidak ditemukan data kabon</h4>';
				
			}
			?>
	</div>
	</div>
    </div>
	</div>
  
   </div>
   <div class="col-md-4">
   <div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Total penggajian karyawan</h3>
    </div>
    <div class="panel-body">
	<div style="padding: 10px 10px 10px;">
          
	</div>
	<div class="well">
	<div style="overflow-y:scroll;height:100px">
            <?php
            $groupgaji=mysql_query("SELECT tanggal_gaji,SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as totgaj from `head_penggajian` group by bulan") or die (mysql_error());
            $no = 1;
            while($objectgroupgaji=mysql_fetch_object($groupgaji)){
			$bulan=date('F Y', strtotime($objectgroupgaji->tanggal_gaji));
			echo'
			<p>'.$bulan.': Rp.<b>'.number_format($objectgroupgaji->totgaj).'</b></p>
			
			';
			
			}
			if($bulan==""){
				echo '<h4>Tidak ditemukan data penggajian</h4>';
				
			}
			?>
	</div>
	</div>
    </div>
	</div>
  
  </div>
 
</div>