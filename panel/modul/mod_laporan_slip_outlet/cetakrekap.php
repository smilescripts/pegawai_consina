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
	include("../../include/function_hitunggaji.php");
	$BULAN=$_GET["BULAN"];
	$TAHUN=$_GET["TAHUN"];
	$DEPT=$_GET["DEPT"];
	$NIP_PEGAWAIH=$_GET["NIP_PEGAWAIH"];
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	$jamsabtu=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='6'") or die (mysql_error());
	$tampiljamsabtu=mysql_fetch_object($jamsabtu);
	$valuesabtu=$tampiljamsabtu->VALUE;

	if($BULAN=="01"){$namabulan="Januari";}
	if($BULAN=="02"){$namabulan="Februari";}
	if($BULAN=="03"){$namabulan="Maret";}
	if($BULAN=="04"){$namabulan="April";}
	if($BULAN=="05"){$namabulan="Mei";}
	if($BULAN=="06"){$namabulan="Juni";}
	if($BULAN=="07"){$namabulan="Juli";}
	if($BULAN=="08"){$namabulan="Agustus";}
	if($BULAN=="09"){$namabulan="September";}
	if($BULAN=="10"){$namabulan="Oktober";}
	if($BULAN=="11"){$namabulan="November";}
	if($BULAN=="12"){$namabulan="Desember";}

	$tahun=$TAHUN;
	$bulanini=$BULAN;
	$harilibur1=array();
	$libur1=mysql_query("select * from hari_libur where BULAN='$bulanini' and TAHUN='$tahun'");
	$viewdata=mysql_fetch_object($libur1);
	$harilibur1=explode(",",$viewdata->TANGGAL);
	$jml_row_tunjangan=mysql_query("select count(KODE_MASTER_TUNJANGAN) from master_tunjangan");
	$hasil_row=mysql_fetch_array($jml_row_tunjangan);
?>
<script>
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
		<h3 class="panel-title">Rekap Counter</h3>
		<p>Periode  :  <?php echo $BULAN; echo" - "; echo $TAHUN; ?> </p>
    </div>
    <div class="panel-body">	


		
	<table border="1" width="100%">
	<thead>
	<tr>
	<th class="tg-031e" rowspan="3"><center >No</center></th>
	<th class="tg-031e" rowspan="3"><center>NIK</center></th>
    <th class="tg-031e" colspan="1"><center>NAMA</center></th>
    <th class="tg-031e" colspan="4"><center>POSISI</center></th>
    <th class="tg-031e" rowspan="3"><center>GAJI POKOK</center></th>
    <th class="tg-031e" colspan="3"><center>UANG MAKAN & TRANSPORT</center></th>
	<th class="tg-031e" colspan="<?php echo $hasil_row[0];?>"><center>TUNJANGAN</center></th>
	<th class="tg-031e" rowspan="3"><center>DITERIMA (TAKE HOME PAY)</center></th>
	<th class="tg-031e" colspan="2"><center>LEMBURAN</center></th>
	<th class="tg-031e" colspan="7"><center>POTONGAN</center></th>
	<th class="tg-031e" rowspan="3"><center>LAIN-LAIN</center></th>
	<th class="tg-031e" rowspan="3"><center>PENGHARGAAN</center></th>
	<th class="tg-031e" rowspan="3"><center>TOTAL DITERIMA (BRI)</center></th>
	<th class="tg-031e" rowspan="3"><center>NOMOR REKENING</center></th>
	<th class="tg-031e" rowspan="3"><center>EMAIL</center></th>
	<th class="tg-031e" rowspan="3"><center>KETERANGAN</center></th>
	
  </tr>
  <tr>
    <td class="tg-031e" rowspan="2"><center>LENGKAP</center></td>
    <td class="tg-031e" rowspan="2"><center>SITE</center></td>
    <td class="tg-031e" rowspan="2"><center>DEPARTEMEN</center></td>
    <td class="tg-031e" rowspan="2"><center>DIVISI</center></td>
	<td class="tg-031e" rowspan="2"><center>JABATAN</center></td>
	
	<td class="tg-031e" rowspan="2"><center>JUMLAH HARI KERJA</center></td>
	<td class="tg-031e" rowspan="2"><center>Rp PER HARI KERJA</center></td>
	<td class="tg-031e" rowspan="2"><center>TOTAL UMT</center></td>
	<?php 
	$tunjangan=mysql_query("select * from master_tunjangan");
	while($gettunjangan=mysql_fetch_object($tunjangan)){
	
	?>
	<td class="tg-031e" rowspan="2"><center><?php echo $gettunjangan->NAMA_TUNJANGAN;?></center></td>
	<?php } ?>
	<td class="tg-031e" rowspan="2"><center>TOTAL JAM</center></td>
	<td class="tg-031e" rowspan="2"><center>JUMLAH LEMBUR</center></td>
	<td class="tg-031e" colspan="2"><center>MANGKIR</center></td>
	<td class="tg-031e" colspan="2"><center>TERLAMBAT</center></td>
	<td class="tg-031e" rowspan="2"><center>PINJAMAN</center></td>
	<td class="tg-031e" rowspan="2"><center>KASBON</center></td>
	<td class="tg-031e" rowspan="2"><center>TOTAL HUTANG</center></td>
  </tr>

  <tr>
	<td class="tg-031e"><center>TOTAL MANGKIR</center></td>
    <td class="tg-031e"><center>JUMLAH POTONGAN</center></td>
    <td class="tg-031e"><center>TOTAL TERLAMBAT</center></td>
    <td class="tg-031e"><center>JUMLAH POTONGAN</center></td>
  </tr>
  </thead>
	<tbody>
  <?php
  $queryrekap = mysql_query("select * from `head_penggajian` join `pegawai` on `pegawai`.kode_pegawai = `head_penggajian`.kode_pegawai where `pegawai`.status_pegawai = 'Tetap' and OUTLET='YA'");
  $no=0;
  while($ambil=mysql_fetch_array($queryrekap)) {
		$ID = $ambil["KODE_PEGAWAI"];
		$queryID = mysql_fetch_object (mysql_query("SELECT * FROM PEGAWAI WHERE kode_pegawai = '$ambil[KODE_PEGAWAI]'"));
		$queryDep = mysql_fetch_object (mysql_query("SELECT * FROM DEPARTEMEN WHERE KODE_DEPARTEMEN = '$ambil[KODE_DEPARTEMEN]'"));
		$queryJab = mysql_fetch_object (mysql_query("SELECT * FROM JABATAN WHERE KODE_DEPARTEMEN = '$ambil[KODE_DEPARTEMEN]'"));
		$queryDiv = mysql_fetch_object (mysql_query("SELECT * FROM DIVISI WHERE ID = '$ambil[KODE_DIVISI]'"));
		$querySite = mysql_fetch_object (mysql_query("SELECT * FROM state WHERE STATE_ID = '$ambil[STATE_ID]'"));
	$no++;
	echo'
	
		<tr>
			<td class="tg-031e">'.$no.'</td>
			<td class="tg-031e">'.$queryID->NIP_PEGAWAI.'</td>
			<td class="tg-031e">'.$queryID->NAMA_PEGAWAI.'</td>
			
			<td class="tg-031e">'.$querySite->STATE_NAME.'</td>
			
			<td class="tg-031e">'.$queryDep->NAMA_DEPARTEMEN.'</td>
			<td class="tg-031e">'.$queryDiv->NAMA.'</td>
			<td class="tg-031e">'.$queryJab->NAMA_JABATAN.'</td>
		
		
			<td class="tg-031e">Rp.'.number_format($queryID->GAJI_POKOK).'</td>
			<td class="tg-031e">'.$ambil["total_masuk"].'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["uang_makan_transport"] / $ambil["total_masuk"] ).'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["uang_makan_transport"]).'</td>
			';
			$tunjangan_gaji=mysql_query("select * from master_tunjangan");
			while($gettunjangan_gaji=mysql_fetch_object($tunjangan_gaji)){
			$tunjangannya=mysql_query("select * from detail_tunjangan_penggajian where kode_penggajian='$ambil[kode_penggajian]' and nama_tunjangan='$gettunjangan_gaji->KODE_MASTER_TUNJANGAN'");
			$get_tunjangannya=mysql_fetch_object($tunjangannya);
			
			if($get_tunjangannya->nama_tunjangan==$gettunjangan_gaji->KODE_MASTER_TUNJANGAN){
				
				echo '<td class="tg-031e">'.$get_tunjangannya->nominal_tunjangan.'</td>'; 
			}
			else{
			echo '<td class="tg-031e">Rp.0</td>';
			}
			}
			echo'
				<td class="tg-031e">Rp.'.number_format($ambil["thp"]).'</td>
			<td class="tg-031e">'.$ambil["total_jam_lembur"].' Jam</td>
			<td class="tg-031e">Rp.'.number_format($ambil["lembur"]).'</td>
			<td class="tg-031e">'.$ambil["mangkir"].'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["potongan_mangkir"]).'</td>
			<td class="tg-031e">'.$ambil["total_terlambat"].'</td>
			<td class="tg-031e">Rp.'.$ambil["terlambat"].'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["pinjaman"]).'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["kasbon"]).'</td>
		
			<td class="tg-031e">
			';
			$totalhutang=$ambil["pinjaman"] +  $ambil["kasbon"];
			echo 'Rp.'.number_format($totalhutang);
			echo '
			</td>
			<td class="tg-031e">Rp.'.number_format($ambil["tabungan"]).'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["nominal_kehadiran_full"]).'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["thp"]).'</td>
			<td class="tg-031e">'.$queryID->NO_REKENING.'</td>
			<td class="tg-031e">'.$queryID->EMAIL.'</td>
			<td class="tg-031e"></td>
  </tr>';
  }
  ?>
  </tbody>
</table>

 
 
	</div>

	</div>
			
	</page>
		
</body>