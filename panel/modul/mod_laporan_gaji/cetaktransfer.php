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
		<h3 class="panel-title">Laporan Gaji Transfer</h3>
		<p>Periode   :  <?php echo $BULAN; echo" - "; echo $TAHUN; ?></p>
    </div>
    <div class="panel-body">	


<table id="gaji_transfer" class="table table-bordered" border="1" width="100%">
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

</page>
		
</body>