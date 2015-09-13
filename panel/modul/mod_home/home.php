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
    <div class="col-md-8">
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
            renderTo: 'container21',
			type: 'column'
           
         },   
		 title: {
            text: 'Grafik pembayaran penggajian karyawan'
         },
         xAxis: {
            categories: ['Nominal penggajian berdasarkan bulan']
         },
         yAxis: {
            title: {
               text: 'Nominal'
            }
         },
              series:             
            [
            <?php 
			$sqla = "SELECT * FROM head_penggajian group by bulan";
            $query1 = mysql_query($sqla) or die(mysql_error()); 
            while( $ret = mysql_fetch_array( $query1) ){
            	$tanggal_gaji=$ret['tanggal_gaji'];
				$bulan=DateTime::createFromFormat('Y-m-d', ''.$ret["tanggal_gaji"].'');
				$nbulan=$bulan->format('M Y');
				
				
                $sql_jumlah   = "SELECT sum(thp) as jumlah FROM head_penggajian  group by bulan";        
				$query_jumlah = mysql_query($sql_jumlah)  or die(mysql_error()); 
                 while( $data = mysql_fetch_array($query_jumlah ) ){
                    $jumlah = $data["jumlah"];   
			
                  }
					$strv=str_replace(",","",number_format($jumlah));
                  ?>
                  {
                      name: '<?php echo $nbulan .' (Rp.'.number_format($jumlah).')'; ?>',
                      data: [<?php echo $strv; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
   
   
   var chart2; // globally available
	$(document).ready(function() {
      chart2 = new Highcharts.Chart({
         chart: {
            renderTo: 'container22',
			type: 'column'
           
         },   
		 title: {
            text: 'Grafik potongan kasbon pegawai'
         },
         xAxis: {
            categories: ['Nominal kasbon pegawai berdasarkan bulan']
         },
         yAxis: {
            title: {
               text: 'Nominal'
            }
         },
              series:             
            [
            <?php 
			$kasbon = "SELECT * FROM head_penggajian group by bulan";
            $querykasbon = mysql_query($kasbon) or die(mysql_error()); 
            while( $retkasbon = mysql_fetch_array($querykasbon) ){
            	$tanggal_kasbon=$retkasbon['tanggal_gaji'];
				$bulankasbon=DateTime::createFromFormat('Y-m-d', ''.$retkasbon["tanggal_gaji"].'');
				$nbulankabon=$bulankasbon->format('M Y');
				$sql_jumlah   = "SELECT sum(kasbon) as jumlahkasbon FROM head_penggajian where tanggal_gaji='$tanggal_kasbon'";        
				$query_jumlah = mysql_query($sql_jumlah)  or die(mysql_error()); 
                 while( $data = mysql_fetch_array($query_jumlah )){
                    $jumlahkasbon = $data["jumlahkasbon"];   
			
                  }             
                  ?>
                  {
                      name: '<?php echo $nbulankabon .' (Rp.'.number_format($jumlahkasbon).')'; ?>',
                      data: [<?php echo "$jumlahkasbon"; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
   
   
   var chart3; // globally available
	$(document).ready(function() {
      chart3 = new Highcharts.Chart({
         chart: {
            renderTo: 'container23',
			type: 'column'
           
         },   
		 title: {
            text: 'Grafik potongan pinjaman pegawai'
         },
         xAxis: {
            categories: ['Nominal pinjaman pegawai berdasarkan bulan']
         },
         yAxis: {
            title: {
               text: 'Nominal'
            }
         },
              series:             
            [
            <?php 
			$pinjaman = "SELECT * FROM head_penggajian group by bulan";
            $querypinjaman = mysql_query($pinjaman) or die(mysql_error()); 
            while($retpinjaman = mysql_fetch_array($querypinjaman) ){
            	$tanggal_pinjaman=$retpinjaman['tanggal_gaji'];
				$bulanpinjaman=DateTime::createFromFormat('Y-m-d', ''.$retpinjaman["tanggal_gaji"].'');
				$nbulanpinjaman=$bulanpinjaman->format('M Y');
				$sql_jumlah   = "SELECT sum(pinjaman) as jumlahpinjaman FROM head_penggajian where tanggal_gaji='$tanggal_pinjaman'";        
				$query_jumlah = mysql_query($sql_jumlah)  or die(mysql_error()); 
                 while( $data = mysql_fetch_array($query_jumlah ) ){
                    $jumlahpinjaman = $data["jumlahpinjaman"];   
			
                  }             
                  ?>
                  {
                      name: '<?php echo $nbulanpinjaman .' (Rp.'.number_format($jumlahpinjaman).')'; ?>',
                      data: [<?php echo "$jumlahpinjaman "; ?>]
                  },
                  <?php } ?>
            ]
      });
   });	
   

</script>
<div style="overflow-y:scroll;height:940px">
<div id="container21" style="height: 400px"></div>
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
        <h3 class="panel-title">Pembayaran Pinjaman karyawan</h3>
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
            $groupgaji=mysql_query("SELECT tanggal_gaji,sum(thp) as totgaj from `head_penggajian` group by bulan") or die (mysql_error());
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
 
  <div class="col-md-4">
   <div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Monitoring sistem</h3>
    </div>
    <div class="panel-body">
	<div style="padding: 10px 10px 10px;">
          
	</div>
	<div class="well">
  

<div class="table-responsive">
    <table id="example" class="table table-bordered">
	<thead>
        <tr>
		<th>Parameter</th>
		<th>Status</th>
		 </tr>
	</thead>
	<tbody>
		<tr>
		<td>Internet Connection</td>
		<td>
		<?php
		if(fsockopen("www.google.com", 80)){echo "<b style='color:green'>Connected</b>";}else{echo "<b style='color:red'>Disconnected</b>";}		
		?></td>
		</tr>
		<tr>
		<td>Database Connection</td>
		<td><?php echo @mysql_ping() ? '<b style="color:green">Connected</b>' : '<b style="color:green">Disconnected</b>';?></td>
		</tr>
		
	</tbody>
    </table>
</div>

	</div>
    </div>
	</div>
  
  </div>
</div>