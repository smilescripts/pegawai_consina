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
	
	$qlembur=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='20'") or die (mysql_error());
	$tampilqlembur=mysql_fetch_object($qlembur);
	$nominallembur=$tampilqlembur->VALUE;

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

<a href="modul/mod_laporan_slip/cetaklaporan.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak slip gaji</a>

<a href="modul/mod_laporan_slip/cetakpdf.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak penggajian Bank</a>


<a href="modul/mod_laporan_slip/cetakpdftunai.php?BULAN=<?php echo $BULAN;?>&TAHUN=<?php echo $TAHUN;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak penggajian Tunai</a>

<hr/>

			
<div class="panel panel-warning" id="non-printable">
	<div class="panel-heading">
		<h3 class="panel-title">Slip gaji</h3>
    </div>
    <div class="panel-body">	



	<?php
		$no = 0;
	
		if($DEPT=="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH' and STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak'"));
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Harian' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
		   
		}
		
		if($DEPT=="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and format='Harian' and kode_pegawai IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak')") or die (mysql_error());
		}
		
		if($DEPT!="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH' and STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak'"));
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Harian' and kode_pegawai='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
		}
		
		if($DEPT!="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM head_penggajian where bulan='$BULAN' and tahun='$TAHUN' and departemen='$DEPT' and format='Harian' and kode_pegawai IN (SELECT KODE_PEGAWAI FROM pegawai WHERE STATE_ID='$_SESSION[STATE_ID]' AND STATUS_PEGAWAI='Kontrak')") or die (mysql_error());
		}
	
		while($objectdata=mysql_fetch_object($query)){
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
				$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->kode_pegawai' and STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
				$getnamapegawaidata=mysql_fetch_object($pegawaidata);
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
					
					$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='15'");
						$tmenit=mysql_fetch_object($qmenit);
						$tmenit2=explode(",",$tmenit->VALUE);
						$ckmenit1=date('H:i', strtotime($getabsensidata->JAM_MASUK));
						$ckmenit2=date('H', strtotime($tampiljam1->JAM_DATANG));
						$ckmenit3=$ckmenit2.":".$tmenit2[0];
						
						if($ckmenit1>$ckmenit3){
							$jammasuknya=$getabsensidata->JAM_MASUK;
						}else{
							$jammasuknya=$tampiljam1->JAM_DATANG;
						}
						
					if($datetime->format('D')=="Sat"){
				
						$jamnya=strtotime($jammasuknya);
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						
						$start1=new DateTime($tampiljam1->JAM_DATANG);
						$end1=new DateTime($jammasuknya);
						if($end1<$start1){
							$jmlhjam=$jamkeluarpegawai->diff($start1)->format('%h'); 
						}else{
							$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
						}
					}
			
					if($datetime->format('D')!="Sat"){
						$jamnya=strtotime($jammasuknya)+60*60*1;
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						
						$start1=new DateTime($tampiljam1->JAM_DATANG);
						$end1=new DateTime($jammasuknya);
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
			
						echo $gajiperhari;
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
			
			<p>Gaji per hari:Rp.<?php echo number_format($pdata->GAJI_POKOK);?></p>
			<p>Lemburan per jam:Rp.<?php echo number_format($nominallembur);?></p>
			<p>(Lemburan akan dibayar bila ada perintah LEMBUR)</p>
			<p>ABSEN ALPA S/D HARI INI:(MAKSIMAL 7 KALI SETAHUN)</p>
			<p>Rumus gaji Senin-Sabtu:(Gaji per hari + Jumlah lembur)</p>
			<p>Rumus gaji Minggu/Hari libur:((Gaji per hari X 2) + (Lembur per jam X 2))</p>
			<p>Penambahan penyesuaian Gaji:Rp.
			<?php
				
				echo number_format($objectdata->penambahan);
			?></p>
		</div>
		<div class="col-md-6">
			<p>Total Cuti: <?php echo $objectdata->jumlah_cuti;?> Hari</p>
			<p>Total potongan gaji untuk pelunasan:Rp.<?php echo  $objectdata->total_potongan;?></p>
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
				<p>Pemotongan penyesuaian Gaji: Rp.
			<?php
				
				echo number_format($objectdata->pemotongan);
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


