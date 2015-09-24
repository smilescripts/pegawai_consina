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
					<td>Rp.'.$objectdata->total_pinjaman.',-</td>
					<td>Rp.'.$objectdata->total_kasbon.',-</td>
					</tr>';
					   
				?>
				</tbody>
			</table>
			<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian,pinjaman maupun kasbon</p>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
			
			 "paging": false,
			"scrollY":200,
			"scrollX":true
			
			
        });
    });
</script>
<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Detail laporan data gaji</h3>
    </div>
    <div class="panel-body">	


 
			<table id="example1" class="table table-bordered" border="1" >
				<thead>
				<tr>
					<th width="10%" style="background-color:grey">No</th>
					<th style="background-color:grey">Pegawai</th>
					<th style="background-color:grey">Departemen</th>
					<th style="background-color:grey">Gaji Pokok</th>
					<th style="background-color:grey">UMT</th>
					<th style="background-color:grey"> tunjangan</th>
					<th style="background-color:grey">Penghargaan</th>
					<th style="background-color:grey">Kasbon</th>
					<th style="background-color:grey">Pinjaman</th>
					<th style="background-color:grey">Potongan</th>
					<th style="background-color:grey"> masuk</th>
					<th style="background-color:grey">Mangkir</th>
					<th style="background-color:grey">Cuti</th>
					<th style="background-color:grey"> penerimaan</th>
					<th style="background-color:grey"> Kehadiran full</th>
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
							<td width="10%">'.$no.'</td>
						';
		
						$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'") or die (mysql_error());
						$getnamapegawaidata=mysql_fetch_object($pegawaidata);
		
						echo'
							<td>'.$getnamapegawaidata->NAMA_PEGAWAI.'</td>
						';
		
						$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$objectdata->departemen'") or die (mysql_error());
						$getnamapenggajian=mysql_fetch_object($penggajiannama);
		
						echo'
							<td>'.$getnamapenggajian->NAMA_DEPARTEMEN.'</td>
						';
		
						echo'
							<td>Rp.'.number_format($objectdata->gaji_pokok).'</td>
							
							<td>Rp.'.number_format($objectdata->uang_makan_transport).'</td>
						
						';
		
						$tunjangandata=mysql_query("SELECT SUM(nominal_tunjangan) as nomtun from detail_tunjangan_penggajian where kode_penggajian='$objectdata->kode_penggajian'") or die (mysql_error());
						$gettunjangandata=mysql_fetch_object($tunjangandata);
		
						echo'
							<td>Rp.'.number_format($gettunjangandata->nomtun).'</td>
							<td>Rp.'.number_format($objectdata->penghargaan).'</td>
							<td>Rp.'.$objectdata->kasbon.'</td>
							<td>Rp.'.$objectdata->pinjaman.'</td>
							<td>Rp.'.$objectdata->total_potongan.'</td>
							<td>'.$objectdata->total_masuk.' Hari</td>
							<td>'.$objectdata->mangkir.' Hari</td>
							<td>'.$objectdata->jumlah_cuti.' Hari</td>
							<td>Rp.'.$objectdata->total_penerimaan.'</td>
							<td>Rp.'.$objectdata->nominal_kehadiran_full.'</td>
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


		<div class="table-responsive" style="height:250px">
 
	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:13px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:13px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
</style>
<table class="tg" style="undefined;table-layout: fixed;">
<colgroup>
<col style="width: 44px">
<col style="width: 209px">
<col style="width: 171px">
<col style="width: 148px">
<col style="width: 164px">
<col style="width: 365px">
</colgroup>
  <tr>
    <th class="tg-s6z2" rowspan="2"><br>NO</th>
    <th class="tg-s6z2" rowspan="2"><br><br>NAMA LENGKAP<br></th>
    <th class="tg-s6z2" colspan="3">POSISI</th>
    <th class="tg-s6z2" rowspan="2"><br>NOMINAL</th>
  </tr>
  <tr>
    <td class="tg-s6z2">SITE</td>
    <td class="tg-s6z2">DEPARTEMEN</td>
    <td class="tg-s6z2">JABATAN</td>
  </tr>
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
		where head_penggajian.bulan='$BULAN' and head_penggajian.tahun='$TAHUN' and (pegawai.NO_REKENING='' or pegawai.NO_REKENING is NULL) ") or die (mysql_error());
     
		
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
							<td>'.$getdept->NAMA_DEPARTEMEN.'</td>
							<td>'.$getsite->STATE_NAME.'</td>
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
  
  
</table>

	</div>
	<h4>Total Penggajian Cash: Rp.<?php echo number_format($getcash->total_gaji_cash);?></h4>
	<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian</p>
	</div>
</div>


<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Gaji Transfer</h3>
    </div>
    <div class="panel-body">	


		<div class="table-responsive" style="height:500px">
 
	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:13px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:13px 10px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
</style>
<table class="tg" style="undefined;table-layout: fixed;">
<colgroup>
<col style="width: 44px">
<col style="width: 209px">
<col style="width: 171px">
<col style="width: 148px">
<col style="width: 164px">
<col style="width: 365px">
</colgroup>
  <tr>
    <th class="tg-s6z2" rowspan="2"><br>NO</th>
    <th class="tg-s6z2" rowspan="2"><br><br>NAMA LENGKAP<br></th>
    <th class="tg-s6z2" colspan="3">POSISI</th>
    <th class="tg-s6z2" rowspan="2"><br>NOMINAL</th>
  </tr>
  <tr>
    <td class="tg-s6z2">SITE</td>
    <td class="tg-s6z2">DEPARTEMEN</td>
    <td class="tg-s6z2">JABATAN</td>
  </tr>
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
							<td>'.$getdept->NAMA_DEPARTEMEN.'</td>
							<td>'.$getsite->STATE_NAME.'</td>
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
  
  
</table>
	</div>
	<h4>Total Penggajian Transfer: Rp.<?php echo number_format($gettrans->total_gaji_trans);?></h4>
	<p>Keterangan: *Nominal yang memiliki nilai Minus dianggap Nol / Kosong pada proses perhitungan Total penggajian</p>
	</div>
</div>
<!-- Laporan anyar -->

<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Laporan Keseluruhan</h3>
    </div>
    <div class="panel-body">	


		<div class="table-responsive">
 
			<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 1701px">
<colgroup>
<col style="width: 40px">
<col style="width: 82px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
<col style="width: 100px">
</colgroup>
  <tr>
    <th class="tg-031e" rowspan="3"><center>No</center></th>
    <th class="tg-031e" rowspan="3"><center>BULAN</center></th>
    <th class="tg-031e" colspan="6"><center>BAGIAN</center></th>
    <th class="tg-031e" colspan="3"><center>POTONGAN HUTANG</center></th>
    <th class="tg-031e" rowspan="3"><center>NILAI</center></th>
    <th class="tg-031e" rowspan="3"><center>KETERANGAN</center></th>
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
  <?php
 /*  if($DEPT=="all"){
	$queryumum = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '23'"));
  	
	$queryumumbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '23'"));
	
	$queryproduksi = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '22'"));
  	
	$queryproduksibri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '22'"));

	$querypemasaran = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '21'"));
  	
	$querypemasaranbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '21'"));
	
	$querypotpemasaran = mysql_fetch_object (mysql_query("SELECT sum(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='23'"));
	
	$querypotproduksi = mysql_fetch_object (mysql_query("SELECT sum(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='22'"));
	
	$querypotumum = mysql_fetch_object (mysql_query("SELECT sum(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='21'"));

	$jumlah = $queryumum->hasil + $queryumumbri->hasil + $queryproduksi->hasil + $queryproduksibri->hasil + $querypemasaran->hasil + $querypemasaranbri->hasil + $querypotpemasaran->hasil + $querypotproduksi->hasil + $querypotumum->hasil ;

	echo'
	
		<tr>
			<td class="tg-031e">'.$queryumum->hasil.'</td>
			<td class="tg-031e">'.$queryumumbri->hasil.'</td>
			<td class="tg-031e">'.$queryproduksi->hasil.'</td>
			<td class="tg-031e">'.$queryproduksibri->hasil.'</td>
			<td class="tg-031e">'.$querypemasaran->hasil.'</td>
			<td class="tg-031e">'.$querypemasaranbri->hasil.'</td>
			<td class="tg-031e">'.$querypotpemasaran->hasil.'</td>
			<td class="tg-031e">'.$querypotproduksi->hasil.'</td>
			<td class="tg-031e">'.$querypotumum->hasil.'</td>
			<td class="tg-031e"></td>
			<td class="tg-031e"></td>
			<td class="tg-031e"></td>
			<td class="tg-031e"></td>
		</tr>
	
	';
		} */
	
			$queryumum = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '23' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
  	
			$queryumumbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '23' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$queryproduksi = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '22' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$queryproduksibri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '22' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));

			$querypemasaran = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING = NULL AND b.KODE_DEPARTEMEN = '21' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$querypemasaranbri = mysql_fetch_object (mysql_query("SELECT SUM((REPLACE(`total_penerimaan`,',','') + `penambahan`)-(`potongan_mangkir` + `pemotongan` + `tabungan`)) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.NO_REKENING != NULL AND b.KODE_DEPARTEMEN = '21' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$querypotpemasaran = mysql_fetch_object (mysql_query("SELECT SUM(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='23' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$querypotproduksi = mysql_fetch_object (mysql_query("SELECT SUM(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='22' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
			
			$querypotumum = mysql_fetch_object (mysql_query("SELECT SUM(kasbon + pinjaman) as hasil FROM `head_penggajian` as a , `pegawai` as b WHERE b.KODE_PEGAWAI = a.KODE_PEGAWAI AND b.KODE_DEPARTEMEN='21' AND a.tahun='$TAHUN' AND a.bulan='$BULAN'"));
		
			$jumlah = $queryumum->hasil + $queryumumbri->hasil + $queryproduksi->hasil + $queryproduksibri->hasil + $querypemasaran->hasil + $querypemasaranbri->hasil + $querypotpemasaran->hasil + $querypotproduksi->hasil + $querypotumum->hasil ;
		
			echo'
	
		<tr>
			<td class="tg-031e"><center>1</center></td>
			<td class="tg-031e"><center>'.$BULAN.'</center></td>
			<td class="tg-031e"><center>'.$queryumum->hasil.'</center></td>
			<td class="tg-031e"><center>'.$queryumumbri->hasil.'</center></td>
			<td class="tg-031e"><center>'.$queryproduksi->hasil.'</center></td>
			<td class="tg-031e"><center>'.$queryproduksibri->hasil.'</center></td>
			<td class="tg-031e"><center>'.$querypemasaran->hasil.'</center></td>
			<td class="tg-031e"><center>'.$querypemasaranbri->hasil.'</center></td>
			<td class="tg-031e"><center>'.$querypotpemasaran->hasil.'</center></td>
			<td class="tg-031e"><center>'.$querypotproduksi->hasil.'</center></td>
			<td class="tg-031e"><center>'.$querypotumum->hasil.'</center></td>
			<td class="tg-031e"><center>'.$jumlah.'</center></td>
			<td class="tg-031e"></td>
		</tr>
	
	';

  
  
  ?>
</table>
 
 
 
		</div>
	</div>
</div>

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

