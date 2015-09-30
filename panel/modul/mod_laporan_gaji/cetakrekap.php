<style>
body {
  background: rgb(204,204,204); 
}
page[size="A4"] {
  background: white;
  width: 21cm;
  height: 29.7cm;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
@media print {
  body, page[size="A4"] {
    margin: 0;
    box-shadow: 0;
  }
}
</style>
<body onload="print()">

<?php 
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	include_once "../../include/koneksi.php";
	$BULAN=$_GET["BULAN"];
	$TAHUN=$_GET["TAHUN"];
	$DEPT=$_GET["DEPT"];

?>




<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Penggajian dan Pinjaman Karyawan</h3>
		<p>Periode   :  <?php echo $BULAN; echo" - "; echo $TAHUN; ?></p>
    </div>
    <div class="panel-body">	


		<div>
			<table border="1" width="100%">
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


		
 

<table id="gaji_all" class="table table-bordered" border="1" width="100%">
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


		<div>
			<table border="1" width="100%">
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

</page>
		

</body>