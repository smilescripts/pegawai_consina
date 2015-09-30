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
		<h3 class="panel-title">Laporan Gaji Cash</h3>
    </div>
    <div class="panel-body">	



<table id="gaji_cash" class="table table-bordered" border="1" >
<thead>
				

  <tr>
    <th class="tg-s6z2" rowspan="2"><br>NO</th>
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br><br>NAMA LENGKAP<br></th>
    <th class="tg-s6z2" style="text-align:center" colspan="4">POSISI</th>
  
    <th class="tg-s6z2" style="text-align:center" rowspan="2"><br>NOMINAL</th>
  </tr>
  <tr>
    <td class="tg-s6z2" style="text-align:center">SITE</td>
    <td class="tg-s6z2" style="text-align:center">DEPARTEMEN</td>
    <td class="tg-s6z2" style="text-align:center">DIVISI</td>
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
						$queryDiv = mysql_fetch_object (mysql_query("SELECT * FROM DIVISI WHERE ID = '$getnamapegawaidata->KODE_DIVISI'"));
		
						echo'
						
							<td>'.$getsite->STATE_NAME.'</td>
							<td>'.$getdept->NAMA_DEPARTEMEN.'</td>
							<td>'.$queryDiv->NAMA.'</td>
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

	</div>
</div>

<table width="100%"> 
<tr> 
	<td colspan="3">Bekasi, <?php echo date('d'); echo" "; echo date('F'); echo" ";  echo date('Y'); ?><p></p></td>
</tr>
<tr>
	<td></td>
	<td><center>Mengetahui,</center></td>
	<td></td>
	
</tr>
<tr>
	<td colspan="3" height="90px"></td>
</tr>
<tr>
	<td><u><center>Heru Nopriyanto</u></center></td>
	<td><u><center>Doddy Purnomo</u></center></td>
	<td><u><center>Heri Kadarsyah</u></center></td>
</tr>
<tr>
	<td><center><i>HR & GA Supervisor</i></center></td>
	<td><center><i>HR & GA</i></center></td>
	<td><center><i>HR Officer Bekasi</i></center></td>
</tr>
<tr>
	<td></td>
	<td><center><p></p>Menyetujui,</center></td>
	<td></td>
</tr>
<tr>
	<td colspan="3" height="90px"></td>
</tr>
<tr>
	<td></td>
	<td><u><center>Disyon Toba,</center></u></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td><i><center>Director</center></i></td>
	<td></td>
</tr>

	
</table>
</page>
		
</body>