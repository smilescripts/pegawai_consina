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
<a href="modul/mod_laporan_slip_bekasi/cetakrekap.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak rekap</a>

<a href="modul/mod_laporan_slip_bekasi/cetaklaporan.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak slip gaji</a>

<a href="modul/mod_laporan_slip_bekasi/cetakpdf.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak penggajian Bank</a>


<a href="modul/mod_laporan_slip_bekasi/cetakpdftunai.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak penggajian Tunai</a>

<hr/>
	<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title">Rekap Harian Bekasi</h3>
    </div>
    <div class="panel-body">	


		
	<table id="gaji_all" class="table table-bordered">
	<thead>
	<tr>
	<th class="tg-031e" rowspan="3"><center >No</center></th>
	<th class="tg-031e" rowspan="3"><center>NIK</center></th>
    <th class="tg-031e" colspan="1"><center>NAMA</center></th>
    <th class="tg-031e" colspan="6"><center>POSISI</center></th>
    <th class="tg-031e" rowspan="3"><center>GAJI PER-HARI</center></th>
    <th class="tg-031e" rowspan="3"><center>LEMBURAN PER-JAM</center></th>
	<th class="tg-031e" rowspan="3"><center>DITERIMA (TAKE HOME PAY)</center></th>
	<th class="tg-031e" colspan="2"><center>LEMBURAN</center></th>
	<th class="tg-031e" colspan="4"><center>POTONGAN</center></th>
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
    <td class="tg-031e" rowspan="2"><center>LINE</center></td>
    <td class="tg-031e" rowspan="2"><center>PENGAWAS</center></td>
	<td class="tg-031e" rowspan="2"><center>JABATAN</center></td>
	
	
	<td class="tg-031e" rowspan="2"><center>TOTAL JAM</center></td>
	<td class="tg-031e" rowspan="2"><center>JUMLAH LEMBUR</center></td>
	<td class="tg-031e" colspan="1"><center>MANGKIR</center></td>
	<td class="tg-031e" rowspan="2"><center>PINJAMAN</center></td>
	<td class="tg-031e" rowspan="2"><center>KASBON</center></td>
	<td class="tg-031e" rowspan="2"><center>TOTAL HUTANG</center></td>
  </tr>

  <tr>
	<td class="tg-031e"><center>TOTAL MANGKIR</center></td>
   
  </tr>
  </thead>
	<tbody>
  <?php
  $queryrekap = mysql_query("select * from `head_penggajian` join `pegawai` on `pegawai`.kode_pegawai = `head_penggajian`.kode_pegawai where `pegawai`.status_pegawai = 'Kontrak Bekasi'");
  $no=0;
  while($ambil=mysql_fetch_array($queryrekap)) {
		$ID = $ambil["KODE_PEGAWAI"];
		$queryID = mysql_fetch_object (mysql_query("SELECT * FROM PEGAWAI WHERE kode_pegawai = '$ambil[KODE_PEGAWAI]'"));
		$queryDep = mysql_fetch_object (mysql_query("SELECT * FROM DEPARTEMEN WHERE KODE_DEPARTEMEN = '$ambil[KODE_DEPARTEMEN]'"));
		$queryDiv = mysql_fetch_object (mysql_query("SELECT * FROM DIVISI WHERE ID = '$ambil[KODE_DIVISI]'"));
		$queryJab = mysql_fetch_object (mysql_query("SELECT * FROM JABATAN WHERE KODE_DEPARTEMEN = '$ambil[KODE_DEPARTEMEN]'"));
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
			<td class="tg-031e">'.$ambil["LINE"].'</td>
			<td class="tg-031e">'.$ambil["PENGAWAS"].'</td>
			<td class="tg-031e">'.$queryJab->NAMA_JABATAN.'</td>
		
		
			<td class="tg-031e">Rp.'.number_format($queryID->GAJI_POKOK).'</td>
			<td class="tg-031e">Rp.'.number_format($ambil["lemburan_perjam"]).'</td>
			
			<td class="tg-031e">Rp.'.number_format($ambil["thp"]).'</td>
			<td class="tg-031e">'.$ambil["total_jam_lembur"].' Jam</td>
			<td class="tg-031e">Rp.'.number_format($ambil["lembur"]).'</td>
			<td class="tg-031e">'.$ambil["mangkir"].' Hari</td>
			
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
			
<div class="panel panel-warning" id="non-printable">
	<div class="panel-heading">
		<h3 class="panel-title">Slip gaji</h3>
    </div>
    <div class="panel-body">	



	<?php
		$no = 0;
	
		if($DEPT=="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH' and STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak Bekasi'"));
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Harian Bekasi' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
		   
		}
		
		if($DEPT=="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Harian Bekasi' and kode_pegawai IN (SELECT KODE_PEGAWAI FROM pegawai WHERE  STATUS_PEGAWAI='Kontrak Bekasi')") or die (mysql_error());
		}
		
		if($DEPT!="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH' and STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak Bekasi'"));
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Harian Bekasi' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
		}
		
		if($DEPT!="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Harian Bekasi' and kode_pegawai IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak Bekasi')") or die (mysql_error());
		}
	
		while($objectdata=mysql_fetch_object($query)){
			
			$lamakerja=mysql_query("SELECT YEAR(`TANGGAL_MASUK`) as tahun FROM `pegawai` WHERE `KODE_PEGAWAI`='$objectdata->KODE_PEGAWAI'");
			$getlamakerja=mysql_fetch_object($lamakerja);
			$tahunsekarang=date("Y");
			$hasillamakerja=$tahunsekarang - $getlamakerja->tahun;
			if($hasillamakerja <= 2){
			$qlembur=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='17'") or die (mysql_error());
			$tampilqlembur=mysql_fetch_object($qlembur);
			$nominallembur=$tampilqlembur->VALUE;
			}
			if($hasillamakerja >= 2 && $hasillamakerja <= 3 ){
			$qlembur=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='18'") or die (mysql_error());
			$tampilqlembur=mysql_fetch_object($qlembur);
			$nominallembur=$tampilqlembur->VALUE;
			}
			if($hasillamakerja >= 3 ){
			$qlembur=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='19'") or die (mysql_error());
			$tampilqlembur=mysql_fetch_object($qlembur);
			$nominallembur=$tampilqlembur->VALUE;
			}
			$totalgaji=0;
			$totaljam=0;
			$totaljamlembur=0;
			$totallembur=0;
			$subtotalgaji=0;
			$no++;
	?>
	<hr/>
	<center><h3><u>SLIP GAJI KARYAWAN CONSINA</u></h3><h3><?php echo $namabulan;?> <?php echo $TAHUN;?></h3></center><hr/>
		<div class="col-md-7">
		    	
			<p><?php echo $profil->ALAMAT; ?>,<?php echo $profil->KOTA; ?>,<?php echo $profil->NEGARA;?> </p>
			<p>Telp:<?php echo $profil->PHONE_1; ?>,<?php echo $profil->PHONE_2; ?> / Fax:<?php echo $profil->PHONE_2; ?></p>
			<p>Email:<?php echo $profil->EMAIL; ?> / www.consina-adventure.com</p>
			<p>No. Bukti Gaji:<?php echo  $objectdata->kode_penggajian;?></p>
		</div> 
		<div class="col-md-5" >
		   	<p>Jakarta , <?php echo  $objectdata->tanggal_gaji;?><p>
			<?php 
				$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai' and STATUS_PEGAWAI='Kontrak Bekasi'") or die (mysql_error());
				$getnamapegawaidata=mysql_fetch_object($pegawaidata);
				$grade_bekasi=mysql_query("select * from grade_bekasi where KODE_GRADE='$getnamapegawaidata->GAJI_POKOK'");
				$pgrade_bekasi=mysql_fetch_object($grade_bekasi);
			?>
		    <p>Kepada Yth :<?php echo  $getnamapegawaidata->NAMA_PEGAWAI;?><p>
		    <p>NIP Karyawan :<?php echo  $getnamapegawaidata->NIP_PEGAWAI;?><p>
			<?php
				$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$getnamapegawaidata->KODE_DEPARTEMEN'") or die (mysql_error());
				$getnamapenggajian=mysql_fetch_object($penggajiannama);
			?>
			<p>Departemen :<?php echo  $getnamapenggajian->NAMA_DEPARTEMEN;?><p>
			<?php
				$jabatan=mysql_query("SELECT * FROM jabatan where KODE_JABATAN='$getnamapegawaidata->KODE_JABATAN'") or die (mysql_error());
				$getjabatan=mysql_fetch_object($jabatan);
			?>
		    <p>Jabatan :<?php echo  $getjabatan->NAMA_JABATAN;?><p>
		</div>
		<hr/>
		<table  class="table table-bordered" id="printable">
			
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Hari</th>
				<th>Masuk</th>
                <th>Pulang</th>
				<th>Total Kerja</th>
                <th>Total Lembur</th>
                <th>Gaji per hari</th>
                <th>Jumlah lembur</th>
                <th>Subtotal Gaji</th>
                
		
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
					$queryjam1=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidata->KODE_JAM_KERJA) or die (mysql_error());
					$tampiljam1=mysql_fetch_object($queryjam1);
					if($datetime->format('D')=="Sat"){
				
						$jamnya=strtotime($getabsensidata->JAM_MASUK);
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						
						$start1=new DateTime($tampiljam1->JAM_DATANG);
						$end1=new DateTime($getabsensidata->JAM_MASUK);
						if($end1<$start1){
							$jmlhjam=$jamkeluarpegawai->diff($start1)->format('%h'); 
						}else{
							$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
						}
					}
			
					if($datetime->format('D')!="Sat"){
						$jamnya=strtotime($getabsensidata->JAM_MASUK)+60*60*1;
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						
						$start1=new DateTime($tampiljam1->JAM_DATANG);
						$end1=new DateTime($getabsensidata->JAM_MASUK);
						if($end1<$start1){
							$jamnya1=strtotime($tampiljam1->JAM_DATANG)+60*60*1;
							$param2=date('H:i:s',$jamnya1);
							$jammasukpegawai2=new DateTime($param2);
							$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai2)->format('%h'); 
						}else{
							$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
						}
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
				<td>Rp.<?php
			
					$gajilembur=0;
					if($datetime->format('D')!="Sat"){
						$JAM_PULANG=new DateTime($tampiljam->JAM_PULANG);	
						$jdatang=strtotime($tampiljam->JAM_DATANG)+60*60*1;
						$param3=date('H:i:s',$jdatang);
						$JAM_DATANG=new DateTime($param3);
						$tjam = $JAM_DATANG->diff($JAM_PULANG)->format('%h');
						$hitungharigaji=$pgrade_bekasi->NOMINAL_GRADE/$tjam;
						
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
									$gajilembur=$nominallembur*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$nominallembur*$lemburdata;	
								}
					
								foreach($harilibur1 as $datalibur1){
									if($getabsensidata->TANGGAL==$datalibur1){
										$gajilembur=$nominallembur*$lemburdata*2;		
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
									$gajilembur=$nominallembur*$lemburdata*2;	
								}
								
								if($datetime->format('D')!="Sun"){
									$gajilembur=$nominallembur*$lemburdata;	
								}
				
								foreach($harilibur1 as $datalibur1){
									if($getabsensidata->TANGGAL==$datalibur1){
										$gajilembur=$nominallembur*$lemburdata*2;		
									}
								}
							}
						}
			
						echo $gajiperhari;
					}
			
			
			
					if($datetime->format('D')=="Sat"){
			
						$hitungharigaji=$pgrade_bekasi->NOMINAL_GRADE/$valuesabtu;
			
						if($jmlhjam > $valuesabtu){
							if($datetime->format('D')=="Sun"){
								$gajiperhari=$hitungharigaji*$valuesabtu*2;
							}
			
							$lemburdata=$jmlhjam-$valuesabtu;
			
							if($lembur > 0){
								if($datetime->format('D')=="Sun"){
									$gajilembur=$nominallembur*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$nominallembur*$lemburdata;	
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
									$gajilembur=$nominallembur*$lemburdata*2;	
								}
				
								if($datetime->format('D')!="Sun"){
									$gajilembur=$nominallembur*$lemburdata;	
								}
							}
						}
			
						echo $gajiperhari;
					}
			
					$totalgaji=$gajiperhari+$totalgaji;
					$totallembur=$gajilembur+$totallembur;
				?></td>
				<td>Rp.<?php echo number_format($gajilembur);?></td>
				<td>
				<?php 
					$subtotal=$gajiperhari+$gajilembur;
					$subtotalgaji=$subtotal+$subtotalgaji;
					echo 'Rp'.number_format($subtotal);
				?>
				</td>
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
				<td>
					<?php 
			
						echo 'Rp.'.number_format($totalgaji);
					?>
				</td>
				<td>
					<?php 
			
						echo 'Rp.'.number_format($totallembur);
					?>
				</td>
				<td>
					<?php 
			
						echo 'Rp.'.number_format($subtotalgaji);
					?>
				</td>
			</tr>
		</table>
		<hr/>
		<div class="col-md-6">
			
			<p>Gaji per hari:Rp.<?php echo number_format($pgrade_bekasi->NOMINAL_GRADE);?></p>
			<p>Lemburan per jam:Rp.<?php echo number_format($nominallembur);?></p>
			<p>(Lemburan akan dibayar bila ada perintah LEMBUR)</p>
			<p>ABSEN ALPA S/D HARI INI:(MAKSIMAL 7 KALI SETAHUN)</p>
			<p>Rumus gaji Senin-Sabtu:(Gaji per hari + Jumlah lembur)</p>
			<p>Rumus gaji Minggu/Hari libur:((Gaji per hari X 2) + (Lembur per jam X 2))</p>
			<p>Pemotongan penyesuaian Gaji: Rp.
			<?php
				
				echo number_format($objectdata->pemotongan);
			?></p>			
		</div>
		<div class="col-md-6">
			<p>Total Cuti: <?php echo $objectdata->jumlah_cuti;?> Hari</p>
			<p>Total potongan gaji untuk pelunasan:Rp.<?php echo $objectdata->total_potongan;?></p>
			<p>Total bonus gaji untuk full 1 bulan masuk:Rp.<?php echo  number_format($objectdata->nominal_kehadiran_full);?></p>
			<p><b>Total terima gaji:Rp.<?php echo  number_format($objectdata->thp);?></b></p>
			<p>Total pengambilan tabungan anda sampai saat ini:<?php
			
				$pengambilantab=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL_PENGAMBILAN) as totalpengambilanpeg FROM pengambilan_tabungan where NIP_PEGAWAI='$getnamapegawaidata->KODE_PEGAWAI'"));
				echo 'Rp.'.number_format($pengambilantab->totalpengambilanpeg);
			?></p>
			<p>Total tabungan anda sampai saat ini:<?php
				$tabungan=mysql_fetch_object(mysql_query("SELECT sum(NOMINAL) as totaltabungan FROM tabungan where NIP='$getnamapegawaidata->KODE_PEGAWAI'"));
			
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
			<p>Penambahan penyesuaian Gaji:Rp.
			<?php
				
				echo number_format($objectdata->penambahan);
			?></p>
		</div>
		<br/>
		<p>
			<table style="margin-top:55px" class="table table-bordered" >
				<tr>
					<th >Pembuat</th>
					<th >Penerima</th>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</table>
		</p>
<?php } ?>

 </div>
</div>


