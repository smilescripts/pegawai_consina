<?php 
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	include_once "../../include/koneksi.php";
	$BULAN=$_GET["BULAN"];
	$TAHUN=$_GET["TAHUN"];
	$DEPT=$_GET["DEPT"];

?>

<script>
    $(document).ready(function() {
        $('#lap_gaji').DataTable( {
			
			 "paging": false,
			"scrollY":500,
			"scrollX":true
			
			
        });
		
    }); 
	$(document).ready(function() {
        $('#gaji_cash').DataTable( {
			
			"paging": false,
			"scrollY":250,
			"scrollX":true
			
			
        });
		
    });
	$(document).ready(function() {
        $('#gaji_transfer').DataTable( {
			
			"paging": false,
			"scrollY":250,
			"scrollX":true
			
			
        });
		
    });	
	$(document).ready(function() {
        $('#gaji_all').DataTable( {
			
			"paging": false,
			"scrollY":200,
			"scrollX":true
			
			
        });
		
    });
</script>
<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Penggajian dan Pinjaman Karyawan</h3>
    </div>
    <div class="panel-body">	


		<div class="table-responsive">
			<table id="example" class="table table-bordered">
				<thead>
					<tr>
					<th>Total Penggajian</th>
					<th>Total Pinjaman</th>
					<th>Total Kasbon</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if($DEPT=="all"){
					$querypetugas=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as total_gaji,sum(kasbon) as total_kasbon,sum(pinjaman) as total_pinjaman from head_penggajian where tahun='$TAHUN' and bulan='$BULAN'") or die (mysql_error());
					$cash=mysql_query("SELECT head_penggajian.*,SUM(CASE WHEN head_penggajian.thp > 0 THEN head_penggajian.thp ELSE 0 END) as total_gaji_cash FROM head_penggajian
					INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
					where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)") or die (mysql_error());
					$getcash=mysql_fetch_object($cash); 
					
					$trans=mysql_query("SELECT head_penggajian.*,SUM(CASE WHEN head_penggajian.thp > 0 THEN head_penggajian.thp ELSE 0 END) as total_gaji_trans FROM head_penggajian
					INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
					where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and pegawai.NO_REKENING!=''") or die (mysql_error());
					$gettrans=mysql_fetch_object($trans); 
					}
					else{
					$querypetugas=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as total_gaji,sum(kasbon) as total_kasbon,sum(pinjaman) as total_pinjaman from head_penggajian where tahun='$TAHUN' and bulan='$BULAN' and departemen='$DEPT'") or die (mysql_error());
					
					$cash=mysql_query("SELECT head_penggajian.*,SUM(CASE WHEN head_penggajian.thp > 0 THEN head_penggajian.thp ELSE 0 END) as total_gaji_cash FROM head_penggajian
					INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
					where  head_penggajian.bulan='$BULAN' and head_penggajian.departemen='$DEPT' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)") or die (mysql_error());
					$getcash=mysql_fetch_object($cash);
					
					$trans=mysql_query("SELECT head_penggajian.*,SUM(CASE WHEN head_penggajian.thp > 0 THEN head_penggajian.thp ELSE 0 END) as total_gaji_trans FROM head_penggajian
					INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
					where  head_penggajian.bulan='$BULAN' and head_penggajian.departemen='$DEPT' and head_penggajian.tahun='$TAHUN'and pegawai.NO_REKENING!=''") or die (mysql_error());
					$gettrans=mysql_fetch_object($trans);
						
						
					}
					$objectdata=mysql_fetch_object($querypetugas);
					echo'
					<tr>
					<td>Rp.'.number_format($objectdata->total_gaji).',-</td>
					<td>Rp.'.number_format($objectdata->total_pinjaman).',-</td>
					<td>Rp.'.number_format($objectdata->total_kasbon).',-</td>
					</tr>';
					   
				?>
				</tbody>
			</table>
			<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian,pinjaman maupun kasbon</p>
		</div>
	</div>
</div>

<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Report Gaji Untuk Keuangan</h3>
    </div>
    <div class="panel-body">	


		
 

<table id="gaji_all" class="table table-bordered" border="1" >
<thead>

  <tr>
    <th class="tg-031e" rowspan="3"><center>BULAN</center></th>
    <th class="tg-031e" colspan="6"><center>BAGIAN</center></th>
    <th class="tg-031e" colspan="3"><center>POTONGAN HUTANG</center></th>
    <th class="tg-031e" rowspan="3"><center>NILAI</center></th>
  </tr>
  <tr>
    <td class="tg-031e" colspan="2"><center>PEMASARAN</center></td>
    <td class="tg-031e" colspan="2"><center>PRODUKSI</center></td>
    <td class="tg-031e" colspan="2"><center>UMUM</center></td>
    <td class="tg-031e" colspan="3"><center>BAGIAN</center></td>
  </tr>
  <tr>
	<td class="tg-031e"><center>CASH</center></td>
    <td class="tg-031e"><center>BRI</center></td>
    <td class="tg-031e"><center>CASH</center></td>
    <td class="tg-031e"><center>BRI</center></td>
    <td class="tg-031e"><center>CASH</center></td>
    <td class="tg-031e"><center>BRI</center></td>
    <td class="tg-031e"><center>PEMASARAN</center></td>
    <td class="tg-031e"><center>PRODUKSI</center></td>
    <td class="tg-031e"><center>UMUM</center></td>


  </tr>
  	</thead>
				<tbody>
  <?php
	
			/* 			$queryumum = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',',''))-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='23' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));

			$queryumumbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='23' and pegawai.NO_REKENING IS NOT NULL"));
			
			$queryproduksi = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='22' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));
			
			$queryproduksibri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='22' and pegawai.NO_REKENING IS NOT NULL"));

			$querypemasaran = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='21' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));
			
			$querypemasaranbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + head_penggajian.`tabungan`)) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='21' and pegawai.NO_REKENING IS NOT NULL"));
			
			$querypotpemasaran = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='23'"));
			
			$querypotproduksi = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='22'"));
																
			$querypotumum = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as hasil FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND pegawai.kode_departemen='21'"));
		
			$jumlah = $queryumum->hasil + $queryumumbri->hasil + $queryproduksi->hasil + $queryproduksibri->hasil + $querypemasaran->hasil + $querypemasaranbri->hasil + $querypotpemasaran->hasil + $querypotproduksi->hasil + $querypotumum->hasil ;
		
			echo'
	
		<tr>
			<td class="tg-031e"><center>1</center></td>
			<td class="tg-031e"><center>'.$BULAN.'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypemasaran->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypemasaranbri->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryproduksi->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryproduksibri->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryumum->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryumumbri->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotpemasaran->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotproduksi->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotumum->hasil).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($jumlah).'</center></td>
			<td class="tg-031e"></td>
		</tr>
	
		'; */
	
	
			$queryumum = mysql_fetch_object (mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as cash_umum FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='23' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));

			$queryumumbri = mysql_fetch_object (mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as trans_umum FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='23' and pegawai.NO_REKENING!=''"));
			
			$queryproduksi = mysql_fetch_object (mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as cash_produksi FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='22' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));
			
			$queryproduksibri = mysql_fetch_object (mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as trans_produksi FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='22' and pegawai.NO_REKENING!=''"));

			$querypemasaran = mysql_fetch_object (mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as cash_pemasaran FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='21' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)"));
			
			$querypemasaranbri = mysql_fetch_object(mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as trans_pemasaran FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='21' and pegawai.NO_REKENING!=''"));
			
			$querypotpemasaran = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as pot_pemasaran FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='23'"));
			
			$querypotproduksi = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as pot_produksi FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='22'"));
																
			$querypotumum = mysql_fetch_object (mysql_query("SELECT SUM(`kasbon` + `pinjaman`) as pot_umum FROM head_penggajian INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' AND head_penggajian.departemen='21'"));
		
			$jumlah = ($queryumum->cash_umum + $queryumumbri->trans_umum + $queryproduksi->cash_produksi + $queryproduksibri->trans_produksi + $querypemasaran->cash_pemasaran + $querypemasaranbri->trans_pemasaran) -($querypotpemasaran->pot_pemasaran + $querypotproduksi->pot_produksi + $querypotumum->pot_umum) ;
			
			echo'
	
		<tr>
			<td class="tg-031e"><center>'.$BULAN.'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypemasaran->cash_pemasaran).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypemasaranbri->trans_pemasaran).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryproduksi->cash_produksi).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryproduksibri->trans_produksi).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryumum->cash_umum).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($queryumumbri->trans_umum).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotpemasaran->pot_pemasaran).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotproduksi->pot_produksi).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($querypotumum->pot_umum).'</center></td>
			<td class="tg-031e"><center>Rp.'.number_format($jumlah).'</center></td>
			
		</tr>
	
	';

  ?>
  </tbody>
</table>

 </div>

	</div>

<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Rekapitulasi Gaji</h3>
    </div>
    <div class="panel-body">	


		<div class="table-responsive">
			<table id="exampleaa" class="table table-bordered">
				<thead>
					<tr>
					<th>No</th>
					<th>Gaji</th>
					<th>Jumlah</th>
					<th>Keterangan</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<td>1</td>
				<td>Payroll Office Jakarta-Bekasi-Bogor-Bandung<br/>Yogyakarta-Malang-Jember-Surabaya-Bali-Makassar</td>
				<td>
				<?php 
				$jumlah_office=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as jumlah_gaji_office FROM head_penggajian where format='Bulanan' or format='Outlet'") or die (mysql_error());
				$getjumlah_office=mysql_fetch_object($jumlah_office); 
				echo 'Rp.'.number_format($getjumlah_office->jumlah_gaji_office);
				?>
				
				</td>
				<td rowspan="3"><br/><br/>Termasuk Tabungan a/n CV Consina Segara Alam</td>
				</tr>
				<tr>
				<td>2</td>
				<td>Payroll Sewing & Helper Jakarta</td>
				<td>
				<?php 
				$jumlah_harian=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as jumlah_gaji_harian FROM head_penggajian where format='Harian'") or die (mysql_error());
				$getjumlah_harian=mysql_fetch_object($jumlah_harian); 
				echo 'Rp.'.number_format($getjumlah_harian->jumlah_gaji_harian);
				?>
				</td>
				<td></td>
				</tr>
				<tr>
				<td>3</td>
				<td>Payroll Sewing & Helper Bekasi</td>
				<td><?php 
				$jumlah_harian_bekasi=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as jumlah_gaji_harian_bekasi FROM head_penggajian where format='Harian Bekasi'") or die (mysql_error());
				$getjumlah_harian_bekasi=mysql_fetch_object($jumlah_harian_bekasi); 
				echo 'Rp.'.number_format($getjumlah_harian_bekasi->jumlah_gaji_harian_bekasi);
				?></td>
				<td></td>
				</tr>
				<tr>
				<td colspan="2"><b>Total Gaji</b></td>
				<td>
				<b>
				<?php
				$totalgaji=$getjumlah_office->jumlah_gaji_office+$getjumlah_harian->jumlah_gaji_harian+$getjumlah_harian_bekasi->jumlah_gaji_harian_bekasi;
				echo 'Rp.'.number_format($totalgaji);
				?>
				</b>
				</td>
				<td></td>
				
				</tr>
				<tr>
				<td colspan="2"><b>Total Payroll</b></td>
				<td><b>Rp.
				<?php 
				$giro_bri=$queryumumbri->trans_umum+$queryproduksibri->trans_produksi+$querypemasaranbri->trans_pemasaran;
				echo number_format($giro_bri);
				
				?>
				</b>
				</td>
				<td>Giro untuk BRI</td>
				
				</tr>
				
				<tr>
				<td colspan="2"><b>Total Cash</b></td>
				<td><b>Rp.
				<?php 
				$tunai=$queryumum->cash_umum+$queryproduksi->cash_produksi+$querypemasaran->cash_pemasaran;
				echo number_format($tunai);
				?>
				</b>
				</td>
				<td>Cek atau Tunai</td>
				
				</tr>
				<!--<tr>
				<td colspan="2"><b>Total Keseluruhan</b></td>
				<td>Rp.</td>
				<td></td>
				
				</tr>-->
				</tbody>
			</table>
			
		</div>
	</div>
</div>

<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Detail laporan data gaji</h3>
    </div>
    <div class="panel-body">	


 
			<table id="lap_gaji" class="table table-bordered" border="1" >
				<thead>
				<tr>
					<th width="5%" style="background-color:grey">No</th>
					<th style="background-color:grey">Pegawai</th>
					<th style="background-color:grey">Kasbon</th>
					<th style="background-color:grey">Pinjaman</th>
					<th style="background-color:grey">Potongan</th>
					<th  width="10%" style="background-color:grey">Mangkir</th>
					<th style="background-color:grey"> penerimaan</th>
					<th style="background-color:grey">THP</th>
				</tr>
				</thead>
				<tbody>
				<?php
					$no = 0;
					
					if($DEPT=="all"){
						$query=mysql_query("SELECT * FROM head_penggajian where tahun='$TAHUN' and bulan='$BULAN'") or die (mysql_error());
       
        
					}
					else{
						$query=mysql_query("SELECT * FROM head_penggajian where tahun='$TAHUN' and bulan='$BULAN' and departemen='$DEPT'") or die (mysql_error());
  	
		
					}
	
					while($objectdata=mysql_fetch_object($query)){
						$no++;
						echo'
							<tr>
							<td width="5%">'.$no.'</td>
						';
		
						$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'") or die (mysql_error());
						$getnamapegawaidata=mysql_fetch_object($pegawaidata);
		
						echo'
							<td>'.$getnamapegawaidata->NAMA_PEGAWAI.'</td>
						';
		
						$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'") or die (mysql_error());
						$getnamapenggajian=mysql_fetch_object($penggajiannama);
		
						echo'
						';
		
						echo'
							
						
						';
		
						$tunjangandata=mysql_query("SELECT SUM(nominal_tunjangan) as nomtun from detail_tunjangan_penggajian where kode_penggajian='$objectdata->kode_penggajian'") or die (mysql_error());
						$gettunjangandata=mysql_fetch_object($tunjangandata);
		
						echo'
							<td>Rp.'.$objectdata->kasbon.'</td>
							<td>Rp.'.$objectdata->pinjaman.'</td>
							<td>Rp.'.$objectdata->total_potongan.'</td>
							<td width="10%">'.$objectdata->mangkir.' Hari</td>
							<td  width="15%">Rp.'.$objectdata->total_penerimaan.'</td>
							<td>Rp.'.number_format($objectdata->thp).'</td>
							</tr>
						';
						
					}

				?>
				</tbody>
			</table>
 
 
	</div>
</div>


<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Gaji Cash</h3>
    </div>
    <div class="panel-body">	



<table id="gaji_cash" class="table table-bordered" border="1" >
<thead>
				

  <tr>
    <th class="tg-s6z2" rowspan="2"><br>NO</th>
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br><br>NAMA LENGKAP<br></th>
    <th class="tg-s6z2" style="text-align:center" colspan="3">POSISI</th>
  
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br>NOMINAL</th>
  </tr>
  <tr>
    <td class="tg-s6z2" style="text-align:center">SITE</td>
    <td class="tg-s6z2" style="text-align:center">DEPARTEMEN</td>
    <td class="tg-s6z2" style="text-align:center">JABATAN</td>
  </tr>
  	</thead>
				<tbody>
  <?php
					$no = 0;
					
					if($DEPT=="all"){
										$query=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL) ") or die (mysql_error());
     
        
					}
					else{
		$query=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL)  and head_penggajian.departemen='$DEPT' ") or die (mysql_error());
     
		
					}
	
					while($objectdata=mysql_fetch_object($query)){
						$no++;
						echo'
							<tr>
							<td width="10%">'.$no.'</td>
						';
		
						$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'") or die (mysql_error());
						$getnamapegawaidata=mysql_fetch_object($pegawaidata);
		
						echo'
						<td>'.$getnamapegawaidata->NAMA_PEGAWAI.'</td>
						';
		
						$dept=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$getnamapegawaidata->KODE_DEPARTEMEN'") or die (mysql_error());
						$getdept=mysql_fetch_object($dept);
						$jabatan=mysql_query("SELECT * FROM jabatan where KODE_JABATAN='$getnamapegawaidata->KODE_JABATAN'") or die (mysql_error());
						$getjabatan=mysql_fetch_object($jabatan);
						$site=mysql_query("SELECT * FROM state where STATE_ID='$getnamapegawaidata->STATE_ID'") or die (mysql_error());
						$getsite=mysql_fetch_object($site);
		
						echo'
						
							<td>'.$getsite->STATE_NAME.'</td>
							<td>'.$getdept->NAMA_DEPARTEMEN.'</td>
							<td>'.$getjabatan->NAMA_JABATAN.'</td>
						';
		
						
		
						$tunjangandata=mysql_query("SELECT SUM(nominal_tunjangan) as nomtun from detail_tunjangan_penggajian where kode_penggajian='$objectdata->kode_penggajian'") or die (mysql_error());
						$gettunjangandata=mysql_fetch_object($tunjangandata);
		
						echo'
						
							<td>Rp.'.number_format($objectdata->thp).'</td>
						
							
							</tr>
						';
					$tcash=$objectdata->thp+$tcash;
					}

				?>
  
  </tbody>
</table>

	<h4>Total Penggajian Cash: Rp.<?php echo number_format($getcash->total_gaji_cash);?></h4>
	<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian</p>
	</div>
</div>


<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Gaji Transfer</h3>
    </div>
    <div class="panel-body">	


<table id="gaji_transfer" class="table table-bordered" border="1" >
<thead>
				

  <tr>
    <th class="tg-s6z2" rowspan="2"><br>NO</th>
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br><br>NAMA LENGKAP<br></th>
    <th class="tg-s6z2" style="text-align:center" colspan="3">POSISI</th>
  
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br>NOMINAL</th>
  </tr>
  <tr>
    <td class="tg-s6z2" style="text-align:center">SITE</td>
    <td class="tg-s6z2" style="text-align:center">DEPARTEMEN</td>
    <td class="tg-s6z2" style="text-align:center">JABATAN</td>
  </tr>
  	</thead>
				<tbody>
  <?php
					$no = 0;
					
					if($DEPT=="all"){
						$query=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and pegawai.NO_REKENING!=''") or die (mysql_error());
     
	
        
					}
					else{
						$query=mysql_query("SELECT head_penggajian.* FROM head_penggajian
		INNER JOIN pegawai on pegawai.KODE_PEGAWAI=head_penggajian.kode_pegawai 
		where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and pegawai.NO_REKENING!='' and head_penggajian.departemen='$DEPT'") or die (mysql_error());
  	
		
					}
	
					while($objectdata=mysql_fetch_object($query)){
						$no++;
						echo'
							<tr>
							<td width="10%">'.$no.'</td>
						';
		
						$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'") or die (mysql_error());
						$getnamapegawaidata=mysql_fetch_object($pegawaidata);
		
						echo'
						<td>'.$getnamapegawaidata->NAMA_PEGAWAI.'</td>
						';
		
						$dept=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$getnamapegawaidata->KODE_DEPARTEMEN'") or die (mysql_error());
						$getdept=mysql_fetch_object($dept);
						$jabatan=mysql_query("SELECT * FROM jabatan where KODE_JABATAN='$getnamapegawaidata->KODE_JABATAN'") or die (mysql_error());
						$getjabatan=mysql_fetch_object($jabatan);
						$site=mysql_query("SELECT * FROM state where STATE_ID='$getnamapegawaidata->STATE_ID'") or die (mysql_error());
						$getsite=mysql_fetch_object($site);
		
						echo'
							<td>'.$getsite->STATE_NAME.'</td>
							<td>'.$getdept->NAMA_DEPARTEMEN.'</td>
							<td>'.$getjabatan->NAMA_JABATAN.'</td>
						';
		
						
		
						$tunjangandata=mysql_query("SELECT SUM(nominal_tunjangan) as nomtun from detail_tunjangan_penggajian where kode_penggajian='$objectdata->kode_penggajian'") or die (mysql_error());
						$gettunjangandata=mysql_fetch_object($tunjangandata);
		
						echo'
						
							<td>Rp.'.number_format($objectdata->thp).'</td>
						
							
							</tr>
						';
		$ttrans=$objectdata->thp+$ttrans;
					}

				?>
  
    </tbody>
</table>

	<h4>Total Penggajian Transfer: Rp.<?php echo number_format($gettrans->total_gaji_trans);?></h4>
	<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian</p>
	</div>
</div>
<!-- Laporan anyar -->

<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Bar Grafik Penggajian</h3>
    </div>
    <div class="panel-body">	
		<script src="modul/mod_laporan_gaji/highcharts.js" type="text/javascript"></script>
		<script src="modul/mod_laporan_gaji/exporting.js" type="text/javascript"></script>
		<script type="text/javascript">
			var chart1; // globally available
			$(document).ready(function() {
			  chart1 = new Highcharts.Chart({
				 chart: {
					renderTo: 'containera',
					type: 'column'
				 },   
				 title: {
					text: 'Grafik Pengeluaran Penggajian'
				 },
				 xAxis: {
					categories: ['Laporan Grafik Penggajian']
				 },
				 yAxis: {
					title: {
					   text: 'Nominal Penggajian'
					}
				 },
					  series:             
					[
					<?php 
					$sqla = "SELECT distinct(kode_penggajian)  FROM head_penggajian  limit 1";
					$query1 = mysql_query($sqla) or die(mysql_error()); 
					while( $ret = mysql_fetch_array( $query1) ){
						$merek=$ret['kode_penggajian'];
						$seri=$ret['kode_penggajian'];                     
						$tipe=$ret['kode_penggajian'];  
						
						 $sql_jumlah   = "SELECT count(kode_penggajian) FROM head_penggajian where kode_penggajian='$merek' limit 1";        
						 
						 $query_jumlah = mysql_query($sql_jumlah)  or die(mysql_error()); 
						 while( $data = mysql_fetch_array($query_jumlah ) ){
							$jumlah = $data[0];   
						if($DEPT=="all"){
				$querypetugas=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as total_gaji,sum(kasbon) as total_kasbon,sum(pinjaman) as total_pinjaman from head_penggajian where tahun='$TAHUN' and bulan='$BULAN'") or die (mysql_error());
				}
				else{
				$querypetugas=mysql_query("SELECT SUM(CASE WHEN thp > 0 THEN thp ELSE 0 END) as total_gaji,sum(kasbon) as total_kasbon,sum(pinjaman) as total_pinjaman from head_penggajian where tahun='$TAHUN' and bulan='$BULAN' and departemen='$DEPT'") or die (mysql_error());
				
					
				}
				$objectdata=mysql_fetch_object($querypetugas);
				$thpf=str_replace(",","",number_format($objectdata->total_gaji));	
						  }             
						  ?>
						  {
							 name: '<?php echo "Total Penggajian ".''.$thpf.''; ?>',
							  data: [<?php echo $thpf; ?>]
						  }, 
						  {
							  name: '<?php echo "Total Kabon ".''.$objectdata->total_kasbon.''; ?>',
							  data: [<?php echo $objectdata->total_kasbon; ?>]
						  },
						  {
							  name: '<?php echo "Total Pinjaman ".''.$objectdata->total_pinjaman.''; ?>',
							  data: [<?php echo $objectdata->total_pinjaman; ?>]
						  },
						  <?php } ?>
					]
			  });
			});	
		</script>
		<div id="containera"></div>

    </div>
</div>

