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
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Mengakses halaman cetak data laporan penggajian karyawan bulanan";
	catat($user,$aksi);
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
	
?>

<?php
	$no = 0;
	
	if($DEPT=="all" && $NIP_PEGAWAIH!=""){
		$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH'"));
		$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Bulanan' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
       
	}
	
	if($DEPT=="all" && $NIP_PEGAWAIH==""){
		$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Bulanan'") or die (mysql_error());
	}
	
	if($DEPT!="all" && $NIP_PEGAWAIH!=""){
		$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH'"));
		$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Bulanan' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
	}
	
	if($DEPT!="all" && $NIP_PEGAWAIH==""){
		$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Bulanan'") or die (mysql_error());
	}
	
	while($objectdata=mysql_fetch_object($query)){
		$totalgaji=0;
		$totaljam=0;
		$totaljamlembur=0;
		$totallembur=0;
		$subtotalgaji=0;
		$no++;
?>
<page size="A4">	
<center><h4>SLIP GAJI KARYAWAN CONSINA <?php echo $namabulan;?> <?php echo $TAHUN;?></h4></center><hr/>
			
	<table width="100%" style="font-size:9pt">
		<tr>
			<th width="60%" style="text-align:left">
				<p ><?php echo $profil->ALAMAT; ?>,<?php echo $profil->KOTA; ?>,<?php echo $profil->NEGARA;?> </p>
				<p>Telp:<?php echo $profil->PHONE_1; ?>,<?php echo $profil->PHONE_2; ?> / Fax:<?php echo $profil->PHONE_2; ?></p>
				<p>Email:<?php echo $profil->EMAIL; ?> / www.consina-adventure.com</p>
				<p>No. Bukti Gaji:<?php echo  $objectdata->kode_penggajian;?></p>
			</th>
		
			
			<th style="text-align:right">
			
		    	<p>Jakarta , <?php echo  $objectdata->tanggal_gaji;?><p>
				<?php 
					$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai' and STATUS_PEGAWAI='Tetap'") or die (mysql_error());
					$getnamapegawaidata=mysql_fetch_object($pegawaidata);
				?>
		    	<p>Kepada Yth :<?php echo  $getnamapegawaidata->NAMA_PEGAWAI;?><p>
		    	<p>NIP Karyawan :<?php echo  $getnamapegawaidata->NIP_PEGAWAI;?><p>
				<?php
					$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$getnamapegawaidata->KODE_DEPARTEMEN'") or die (mysql_error());
					$getnamapenggajian=mysql_fetch_object($penggajiannama);
				?>
				<?php
					$jabatan=mysql_query("SELECT * FROM jabatan where KODE_JABATAN='$getnamapegawaidata->KODE_JABATAN'") or die (mysql_error());
					$getjabatan=mysql_fetch_object($jabatan);
				?>
				<p>Departemen / Jabatan :<?php echo  $getnamapenggajian->NAMA_DEPARTEMEN;?> / <?php echo  $getjabatan->NAMA_JABATAN;?><p>
				
		    	
			 </th>
		</tr>
	</table>
	<br/>
	<center>
		<table  border=1 id="printable" style="font-size:8.5pt" width="100%">
			<tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Hari</th>
				<th>Masuk</th>
                <th>Pulang</th>
				<th>Total Kerja</th>
                <th>Total Lembur</th>
            </tr>
			<?php 
				$absensidata=mysql_query("SELECT * FROM absensi  where TANGGAL BETWEEN '$objectdata->start' AND '$objectdata->end' and NIP_PEGAWAI='$objectdata->kode_pegawai' ORDER BY TANGGAL") or die (mysql_error());
				$no=0;
			
				while($getabsensidata=mysql_fetch_object($absensidata)){
			
					$datapegawai=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai'") or die (mysql_error());	
					$pdata=mysql_fetch_object($datapegawai);
					$no++;
			?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $getabsensidata->TANGGAL;?></td>
				<td><?php
					$datetime = DateTime::createFromFormat('Y-m-d', ''.$getabsensidata->TANGGAL.'');
			
					if($datetime->format('D')=="Mon"){$hari="Senin";}
					if($datetime->format('D')=="Tue"){$hari="Selasa";}
					if($datetime->format('D')=="Wed"){$hari="Rabu";}
					if($datetime->format('D')=="Thu"){$hari="Kamis";}
					if($datetime->format('D')=="Fri"){$hari="Jumat";}
					if($datetime->format('D')=="Sat"){$hari="Sabtu";}
					if($datetime->format('D')=="Sun"){$hari="Minggu";}
					echo $hari ;
				?></td>
				<td><?php echo $getabsensidata->JAM_MASUK;?></td>
				<td><?php echo $getabsensidata->JAM_KELUAR;?></td>
				<td><?php 
					if($datetime->format('D')=="Sat"){
				
						$jamnya=strtotime($getabsensidata->JAM_MASUK);
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
					}
			
					if($datetime->format('D')!="Sat"){
						$jamnya=strtotime($getabsensidata->JAM_MASUK)+60*60*1;
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
					}
					$totaljam=$jmlhjam+$totaljam;
					echo $jmlhjam.' Jam';
				?></td>
				<td><?php
			
					if($datetime->format('D')!="Sat"){
						$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidata->KODE_JAM_KERJA) or die (mysql_error());
						$tampiljam=mysql_fetch_object($queryjam);
						$start=new DateTime($tampiljam->JAM_PULANG);
						$end=new DateTime($getabsensidata->JAM_KELUAR);
			
						if($end < $start){$lembur = 0 ;}
						else{$lembur = $end->diff($start)->format('%h'); }
					}
			
					if($datetime->format('D')=="Sat"){
			
						if($jmlhjam < $valuesabtu){$lembur = 0 ;}
						else{$lembur = $jmlhjam-$valuesabtu; }
					}
					$totaljamlembur=$lembur+$totaljamlembur;
					echo $lembur.' Jam';
				?></td>
			<?php
			
				$gajilembur=0;
					if($datetime->format('D')!="Sat"){
						$JAM_PULANG=new DateTime($tampiljam->JAM_PULANG);	
						$jdatang=strtotime($tampiljam->JAM_DATANG)+60*60*1;
						$param3=date('H:i:s',$jdatang);
						$JAM_DATANG=new DateTime($param3);
						$tjam = $JAM_DATANG->diff($JAM_PULANG)->format('%h');
						$hitungharigaji=$getnamapegawaidata->GAJI_POKOK/$tjam;
						
						if($jmlhjam > $tjam){
			
							if($datetime->format('D')=="Sun"){
								$gajiperhari=$hitungharigaji*$tjam*2;
							}
			
							if($datetime->format('D')!="Sun"){
								$gajiperhari=$hitungharigaji*$tjam;
							}
			
							foreach($harilibur1 as $datalibur1){
								if($getabsensidata->TANGGAL==$datalibur1){
									$gajiperhari=$hitungharigaji*$tjam*2;	
								}
							} 	
							$lemburdata=$jmlhjam-$tjam;
			
							if($lembur > 0){
								if($datetime->format('D')=="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata;	
								}
				
								foreach($harilibur1 as $datalibur1){
									if($getabsensidata->TANGGAL==$datalibur1){
										$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;		
									}
								} 	
							}
				
						}
						else{
				
							if($datetime->format('D')=="Sun"){
				
								$gajiperhari=$hitungharigaji*$jmlhjam*2;
							}
			
							if($datetime->format('D')!="Sun"){
								$gajiperhari=$hitungharigaji*$jmlhjam;
							}
			
							foreach($harilibur1 as $datalibur1){
								if($getabsensidata->TANGGAL==$datalibur1){
									$gajiperhari=$hitungharigaji*$tjam*2;	
								}
							} 	
							$lemburdata=$jmlhjam-$tjam;
			
							if($lembur > 0){
								if($datetime->format('D')=="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata;	
								}
				
								foreach($harilibur1 as $datalibur1){
									if($getabsensidata->TANGGAL==$datalibur1){
										$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;		
									}
								}
							}
						}
					}
			
					if($datetime->format('D')=="Sat"){
						$hitungharigaji=$getnamapegawaidata->GAJI_POKOK/$valuesabtu;
			
						if($jmlhjam > $valuesabtu){
							if($datetime->format('D')=="Sun"){
								$gajiperhari=$hitungharigaji*$valuesabtu*2;
							}
							$lemburdata=$jmlhjam-$valuesabtu;
			
							if($lembur > 0){
								if($datetime->format('D')=="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata;	
								}
							}
						}
						else{
							if($datetime->format('D')=="Sun"){
								$gajiperhari=$hitungharigaji*$jmlhjam*2;
							}
				
							if($datetime->format('D')!="Sun"){
								$gajiperhari=$hitungharigaji*$jmlhjam;
							}
							$lemburdata=$jmlhjam-$valuesabtu;
				
							if($lembur > 0){
								if($datetime->format('D')=="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$pdata->NOMINAL_LEMBUR*$lemburdata;	
								}
							}
						}
			
					}
					$totalgaji=$gajiperhari+$totalgaji;
					$totallembur=$gajilembur+$totallembur;
				?>
			
			
			</tr>
			<?php 
				} 
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
				<?php 
			
					echo $totaljam.' Jam';
				?>
				</td>
				<td>
				<?php 
			
					echo $totaljamlembur.' Jam';
				?>
				</td>
			</tr>
		</table>
	</center>
	<br/>
	<table width="100%" style="font-size:9pt">
		<tr>
			<th width="60%" style="text-align:left">
				<p>Gaji per bulan:Rp.<?php echo number_format($getnamapegawaidata->GAJI_POKOK);?></p>
			<p>Tunjangan Lainnya:Rp.<?php echo number_format(gettunjangan($getnamapegawaidata->NIP_PEGAWAI));?></p>
				<p>UMT:Rp.<?php echo number_format($objectdata->uang_makan_transport);?></p>
				<p>Lembur:Rp.<?php echo $objectdata->lembur;?></p>
				<p>Penghargaan:Rp.<?php echo number_format($objectdata->penghargaan);?></p>
				<p>Potongan terlambat:Rp.<?php echo number_format($objectdata->terlambat);?></p>
				<p>Potongan Kasbon:Rp.<?php echo number_format($objectdata->kasbon);?></p>
				<p>Potongan Pinjaman:Rp.<?php echo number_format($objectdata->pinjaman);?></p>
				<p>Potongan Tabungan:Rp.<?php echo number_format($objectdata->tabungan);?></p>
			
			</th>
			<th style="text-align:right">
				<p>Total potongan gaji:Rp.<?php echo  $objectdata->total_potongan;?></p>
				<p>Total mangkir (<?php echo  $objectdata->mangkir;?> Hari): Rp.<?php echo  number_format($objectdata->potongan_mangkir);?></p>
		
				<p><b>Total terima gaji:Rp.<?php echo  number_format($objectdata->thp);?></b></p>
				<p>Total pengambilan tabungan anda sampai saat ini:<?php
			
					$pengambilantab=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilanpeg FROM pengambilan_tabungan where NIP_PEGAWAI='$getnamapegawaidata->KODE_PEGAWAI'"));
					echo 'Rp.'.number_format($pengambilantab->totalpengambilanpeg);
				?></p>
				<p>Total tabungan anda sampai saat ini:<?php
					$tabungan=mysql_fetch_object(mysql_query("SELECT sum(tabungan) as totaltabungan FROM head_penggajian where kode_pegawai='$getnamapegawaidata->KODE_PEGAWAI'"));
			
					$pengambilan=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilan FROM pengambilan_tabungan where NIP_PEGAWAI='$getnamapegawaidata->KODE_PEGAWAI'"));
			
					$subtotaltabungan=$tabungan->totaltabungan-$pengambilan->totalpengambilan;
			
					if($subtotaltabungan <=0){$tb=0;}
					if($subtotaltabungan > 0){$tb=$subtotaltabungan;}
					echo 'Rp.'.number_format($tb);
				?></p>
				<p>Tanggal mulai Nabung:
				<?php
					$tnabung=mysql_fetch_object(mysql_query("SELECT tanggal_gaji as tanggalnabung FROM head_penggajian where kode_pegawai='$getnamapegawaidata->KODE_PEGAWAI' and tabungan!='0'  order by tanggal_gaji asc limit 1"));
					echo $tnabung->tanggalnabung;
				?></p>
			</th>
		</tr>
	</table>
	<br/>
	<p><center><table border=1 >
		<tr>
            <th width="30%">Pembuat</th>
            <th width="30%">Penerima</th>
		</tr>
		<tr>
			<td><br/><br/></td>
			<td><br/><br/></td>
		</tr>
	</table></center></p>
</page>
		
<?php } ?>


</body>