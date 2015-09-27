<?php 
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji_harian.php");
	$startp=$_GET["start"];
	$endp=$_GET["end"];
	
	$tBULAN=new DateTime($endp);
	$tTAHUN=new DateTime($endp);
	
	$BULAN=$tBULAN->format("m");
	$TAHUN=$tTAHUN->format("Y");
	$DEPT=$_GET["DEPT"];
	$NIP_PEGAWAIH=$_GET["NIP_PEGAWAIH"];
	$profil=mysql_fetch_object(mysql_query("SELECT * FROM profil_perusahaan"));
	$jamsabtu=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='6'") or die (mysql_error());
	$tampiljamsabtu=mysql_fetch_object($jamsabtu);
	$valuesabtu=$tampiljamsabtu->VALUE;
	$full=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='7'") or die (mysql_error());
	$tampilfull=mysql_fetch_object($full);
	$valuefull=$tampilfull->VALUE;
	
	$qlembur=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='20'") or die (mysql_error());
	$tampilqlembur=mysql_fetch_object($qlembur);
	$nominallembur=$tampilqlembur->VALUE;
	
	$qtabungan=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='12'") or die (mysql_error());
	$tampilqtabungan=mysql_fetch_object($qtabungan);
	$nominaltabungan=$tampilqtabungan->VALUE;
	
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



		
<div class="panel panel-warning" id="non-printable">
	<div class="panel-heading">
		<h3 class="panel-title">Slip gaji</h3>
    </div>
	<div class="btnbantuan" style="margin-top:-37px;">
							<a href="modul/mod_rekapitulasi_harian/cetaklaporan.php?start=<?php echo $startp;?>&end=<?php echo $endp;?>&DEPT=<?php echo $DEPT;?>&NIP_PEGAWAIH=<?php echo $NIP_PEGAWAIH;?>" target="_blank" class="btn btn-info">Cetak data rekapitulasi</a>

							</div>
   	
	<?php
		$Akhir = new DateTime('01-'.$BULAN.'-'.$TAHUN);
		$Akhir->modify('last day of this month');
		$Awal = new DateTime('01-'.$BULAN.'-'.$TAHUN);
		$Awal->modify('first day of this month');
		$tawal=$Awal->format('Y-m-d');
		$takhir=$Akhir->format('Y-m-d');
	
$dateawalnya = $Awal->format('d-m-Y');
$dateakhirnya = $Akhir->format('d-m-Y');
$pecahminggu = explode("-", $dateawalnya);
$tglminggu = $pecahminggu[0];
$blnminggu = $pecahminggu[1];
$thnminggu = $pecahminggu[2];
$im = 0;
$jumlahminggu = 0;
do
{
   $minggu = date("d-m-Y", mktime(0, 0, 0, $blnminggu, $tglminggu+$im, $thnminggu));

   if (date("w", mktime(0, 0, 0, $blnminggu, $tglminggu+$im, $thnminggu)) == 0)
   {
     $jumlahminggu++;
    
   } 	 
	$im++;
}
while ($minggu != $dateakhirnya);   
	
		/* function hitung_minggu($tawal,$takhir) {
			$adaysec =24*3600;
			$tgl1= strtotime($tawal);
			$tgl2= strtotime($takhir);
			$minggu=0;
			
			for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
				if (date("w",$i) =="0") { $minggu++;}
			}
			return $minggu;
		} */
	 
		/* function hitung_sabtu($tawal,$takhir) {
			$adaysec =24*3600;
			$tgl1= strtotime($tawal);
			$tgl2= strtotime($takhir);
			$sabtu=0;
			for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
				if (date("w",$i) =="6") {$sabtu++;}
			}
			return $sabtu;
		} */
	
		function selisihHari($tglAwal, $tglAkhir)
		{
			$tglLibur = Array("2015-08-05", "2013-01-05", "2013-01-17");
			$tahun=$TAHUN;
			$bulanini=$BULAN;
			$libur1=mysql_query("select * from hari_libur where BULAN='$bulanini' and TAHUN='$tahun'");
	
			while($viewdata=mysql_fetch_object($libur1)){
				$harilibur1=array();
				$harilibur1=explode(",",$viewdata->TANGGAL);
				foreach($harilibur1 as $datalibur1){
				} 
			}
			
			$jumlahlibur1=count($harilibur1);
			$
			$pecah1 = explode("-", $tglAwal);
			$date1 = $pecah1[2];
			$month1 = $pecah1[1];
			$year1 = $pecah1[0];
			$pecah2 = explode("-", $tglAkhir);
			$date2 = $pecah2[2];
			$month2 = $pecah2[1];
			$year2 =  $pecah2[0];
			$jd1 = GregorianToJD($month1, $date1, $year1);
			$jd2 = GregorianToJD($month2, $date2, $year2);
			$selisih = $jd2 - $jd1;
	
			for($i=1; $i<=$selisih; $i++)
			{
        
				$tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
				$tglstr = date("Y-m-d", $tanggal);
		
				if (in_array($tglstr, $tglLibur))
				{
					$libur1++;
				}
		
				if ((date("N", $tanggal) == 7))
				{
					$libur2++;
				}
			}
			return $selisih-$jumlahlibur1-$libur2;
		}
	
		$no = 0;
		if($DEPT=="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH'"));
			$query=mysql_query("SELECT * FROM pegawai WHERE STATUS_PEGAWAI='Kontrak'  and KODE_PEGAWAI='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
       
		}
	
		if($DEPT=="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM pegawai WHERE STATUS_PEGAWAI ='Kontrak'") or die (mysql_error());
		}
	
		if($DEPT!="all" && $NIP_PEGAWAIH!=""){
			$pegawaicari=mysql_fetch_object(mysql_query("SELECT * FROM pegawai where NIP_PEGAWAI='$NIP_PEGAWAIH'"));
			$query=mysql_query("SELECT * FROM pegawai where KODE_DEPARTEMEN='$DEPT' and STATUS_PEGAWAI ='Kontrak' and KODE_PEGAWAI='$pegawaicari->KODE_PEGAWAI'") or die (mysql_error());
		}
	
		if($DEPT!="all" && $NIP_PEGAWAIH==""){
			$query=mysql_query("SELECT * FROM pegawai where KODE_DEPARTEMEN='$DEPT' and STATUS_PEGAWAI='Kontrak' and STATE_ID='$_SESSION[STATE_ID]'") or die (mysql_error());
		}
	
		while($objectdata=mysql_fetch_object($query)){
			$totalgaji=0;
			$totaljam=0;
			$totaljamlembur=0;
			$totallembur=0;
			$subtotalgaji=0;
			$no++;
	
			/* batas  */
			$NIP=$objectdata->NIP_PEGAWAI;
			$data=pegawai($NIP);
			$kp=$data->KODE_PEGAWAI;
			$jabatan=jabatan($data->KODE_JABATAN);
			$departemen=departemen($data->KODE_DEPARTEMEN);
			$KODE_DEPARTEMEN=$objectdata->KODE_DEPARTEMEN;

			$pinjaman=mysql_query("select SUM(CICILAN_PERBULAN) as CICILAN_PERBULAN  from pinjaman where KODE_PEGAWAI='$kp' and SISA_CICILAN >'0'");
			$getpinjaman=mysql_fetch_object($pinjaman);
			$nominalpinjaman=$getpinjaman->CICILAN_PERBULAN;
			$sisa_cicilan=$getpinjaman->SISA_CICILAN;
			$hutang=gethutangrekap($kp,$BULAN,$TAHUN);	
			$gaji_pokok=$data->GAJI_POKOK;
			$lembur=number_format(nominalumt(gajilembur($NIP)));
			$tabungan=$nominaltabungan;
			$tanggal_gaji=date("Y-m-d");
			/* $query = "SELECT max(kode_penggajian) as idMaks FROM head_penggajian";
			$hasil = mysql_query($query);
			$data  = mysql_fetch_array($hasil);
			$nim = $data['idMaks'];
			$noUrut = (int) substr($nim, 9, 5);
			$noUrut++;
			$inisial=date('d/m/').'GH-';
			$w = $inisial;
			$IDbaru = $char . sprintf("%05s", $noUrut);
			$getkode=$w.$IDbaru; */
			//$tipe=$_POST["tipe"];
			$kasbon=$hutang->hutangnya;
/* ------------------Fungsi mangkir-------------------- */
			$kalender=CAL_GREGORIAN;
			$bulan=$BULAN;
			$tahun=$TAHUN;
			$hari=cal_days_in_month($kalender,$bulan,$tahun);
			$bulanini=$BULAN;
			$queryabsensi_data=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'") or die (mysql_error());
			$absen=array();
	
			while($objectdata1[]=mysql_fetch_array($queryabsensi_data)){
			}
	
			$cekdata=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and TANGGAL BETWEEN '$startp' AND '$endp'");
			$ada=mysql_fetch_object($cekdata);
			$jumlahmasukabsen=mysql_query("SELECT count(TANGGAL) as totmasuk FROM absensi where NIP_PEGAWAI='$kp' and TANGGAL BETWEEN '$startp' AND '$endp' and JAM_KELUAR!='00:00:00'");
			$datajumlahmasukabsen=mysql_fetch_object($jumlahmasukabsen);
			$cekada=$ada->TANGGAL;
			$cekpenyesuaian=mysql_query("SELECT TANGGAL FROM detail_penyesuaian_absensi where KODE_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
			$datacekpenyesuaian=mysql_fetch_object($cekpenyesuaian);
			$jumlahmasukabsenpen=mysql_query("SELECT count(TANGGAL) as totmasukpenyesuaian FROM detail_penyesuaian_absensi where KODE_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
			$datajumlahmasukabsenpenyesiuaian=mysql_fetch_object($jumlahmasukabsenpen);
			$cekadapenyesuian=$datacekpenyesuaian->TANGGAL;
	
			if($cekada!=""){
				$jumlahmasuk=$datajumlahmasukabsen->totmasuk;
			}
	
			if($cekada==""){
				$jumlahmasuk=0;
			}
	
			$tahun=$TAHUN;
			$bulanini=$BULAN;
			$libur=mysql_query("select * from hari_libur where BULAN='$bulanini' and YEAR(TANGGAL)='$tahun'");
	
			while($viewdata=mysql_fetch_object($libur)){
				$harilibur=array();
				$harilibur=explode(",",$viewdata->TANGGAL);
				
				foreach($harilibur as $datalibur){
				} 
			}
			$jumlahlibur=count($harilibur);
	
	/* -------------------------------------- */
			$getcuti=mysql_query("select * from cuti where NIP_PEGAWAI='$kp' and MONTH(TANGGAL_AWAL)='$bulanini' and YEAR(TANGGAL_AWAL)='$tahun'");
			$tanggalcuti=mysql_fetch_object($getcuti);
			if($tanggalcuti->TANGGAL_AWAL!=""){
				$tanggalawalcuti=$tanggalcuti->TANGGAL_AWAL;
				$tanggalakhircuti=$tanggalcuti->TANGGAL_AKHIR;

				$tgl1 =$tanggalawalcuti;
				$tgl2 =$tanggalakhircuti;
				$jumlahcuti1=dateRange($tgl1,$tgl2);
				$hrmingggu=selisihHariMinggu($tgl1,$tgl2);
				foreach($harilibur1 as $datalibur12){
					$startcuti = $tgl1;
					$endcuti = $tgl2;
					while (strtotime($startcuti) <= strtotime($endcuti)) {
						if($startcuti==$datalibur12){
								$liburcuti=$liburcuti+1;	
							}
						$startcuti = date ("Y-m-d", strtotime("+1 day", strtotime($startcuti)));
					 }
					
				}
				$jumlahcuti=$jumlahcuti1-$hrmingggu-$liburcuti;
				
				if($jumlahcuti<=0){
					$hasiljumlahcuti=0;
				}

				if($jumlahcuti>0){
					$hasiljumlahcuti=$jumlahcuti;
				}
			}else{
				$hasiljumlahcuti=0;
			}
			
	/* -------------------------------------- */
			$uang_makan_transport=$objectdata->NOMINAL_UMT *$jumlahmasuk ;

			$takehomepay=getthp($NIP) - ($hutang->hutangnya+$nominalpinjaman+$nominaltabungan);
			$hitungjumlahharikerja=dateRange($startp,$endp)-selisihHariMinggu($startp,$endp)-$jumlahlibur;
			/*----- $hasiljumlahcuti blm sesuai karena perubahan input proses menggunakan tgl periode ------- */
			$mangkir=$hitungjumlahharikerja-$jumlahmasuk-$hasiljumlahcuti;
	
			if($mangkir<=0){
			$hasil=0;
			if($hasiljumlahcuti==0){
				$nominal_kehadiran_full=$valuefull;
			}else{
				$nominal_kehadiran_full=0;
			}
			
			}
	
			if($mangkir>0){
			$hasil=$mangkir;
			$nominal_kehadiran_full=0;
			}
	
			$pot_mangkir=0;
			$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
			$getpenghargaan=mysql_fetch_object($penghargaan);
			$totalpenghargaan=$objectdata->PENGHARGAAN;
			$terlambat=potogan_terlambat($NIP);
			/* $takehomepayfix=getthp($NIP) + $uang_makan_transport+$objectdata->PENGHARGAAN - ($hutang->hutangnya+$nominalpinjaman+$objectdata->TABUNGAN+$terlambat); */
			$total_potongan=number_format($hutang->hutangnya+$nominaltabungan+$nominalpinjaman+$terlambat);
			$total_penerimaan=number_format(getthp($NIP) + $uang_makan_transport +$totalpenghargaan);
	
			/* batas  */
	?>
	<hr/>
	
	 <div class="panel-body">
	<center><h3><u>REKAPITULASI ABSENSI KEHADIRAN KARYAWAN HARIAN(JAKARTA)</u></h3><h3><?php echo $namabulan;?> <?php echo $TAHUN;?></h3></center>
			
		<div class="col-md-7" >
			<?php 
				$pegawaidata=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->KODE_PEGAWAI' and STATUS_PEGAWAI='Kontrak'") or die (mysql_error());
				$getnamapegawaidata=mysql_fetch_object($pegawaidata);
				$penyesuaian_pemotongan=mysql_query("select *,SUM(NOMINAL) as total from penyesuaian_dana where KODE_PEGAWAI='$getnamapegawaidata->KODE_PEGAWAI' and STATUS='Pemotongan' and BULAN='$bulanini' and TAHUN='$tahun' GROUP BY KODE_PEGAWAI");
				$get_penyesuaian_pemotongan=mysql_fetch_object($penyesuaian_pemotongan);
				$nominal_pemotongan=$get_penyesuaian_pemotongan->total;
				
				$penyesuaian_penambahan=mysql_query("select *,SUM(NOMINAL) as total from penyesuaian_dana where KODE_PEGAWAI='$getnamapegawaidata->KODE_PEGAWAI' and STATUS='Penambahan' and BULAN='$bulanini' and TAHUN='$tahun' GROUP BY KODE_PEGAWAI");
				$get_penyesuaian_penambahan=mysql_fetch_object($penyesuaian_penambahan);
				$nominal_penambahan=$get_penyesuaian_penambahan->total;
				$tambah_pemotongan=0;
				$tambah_penambahan=0;
				if($nominal_pemotongan!=""){
					
					$penyesuaian="Penyesuaian Pemotongan Gaji Bulan Ini Sebesar";
					$nominal_pemotongan=$nominal_pemotongan;
					$fix_pemotongan=$penyesuaian.' : Rp.'.number_format($nominal_pemotongan);
					$tambah_pemotongan=$nominal_pemotongan;
					
					
				}
				if($nominal_penambahan!=""){
					
					$penyesuaian_tambah="Penyesuaian Penambahan Gaji Bulan Ini Sebesar";
					$nominal_penambahan=$nominal_penambahan;
					$fix_penambahan=$penyesuaian_tambah.' : Rp.'.number_format($nominal_penambahan);
					$tambah_penambahan=$nominal_penambahan;
					
				}
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
		<div class="col-md-5">
		<p style="text-align:right">Total mangkir(<?php echo  $hasil;?> Hari)</p>
		</div>
		<hr/>
		
		<table  class="table table-bordered" id="printable">
		<tr>
    <th class="tg-9hbo" rowspan="2"><br>NO</th>
    <th class="tg-9hbo" rowspan="2" style="text-align:center"><br>TANGGAL</th>
    <th class="tg-amwm" rowspan="2" style="text-align:center"><br>HARI</th>
    <th class="tg-amwm" colspan="3" style="text-align:center">KETENTUAN</th>
    <th class="tg-amwm" rowspan="2" style="text-align:center"><br>ABSEN<br>(IN)</th>
    <th class="tg-amwm" rowspan="2" style="text-align:center"><br>ABSEN<br>(OUT)</th>
	<th class="tg-amwm" rowspan="2" style="text-align:center"><br>TERLAMBAT</th>
	<th class="tg-amwm" rowspan="2" style="text-align:center"><br>PULANG AWAL</th>
    <th class="tg-amwm" rowspan="2" style="text-align:center"><br>TOTAL <br/>JAM</th>
    <th class="tg-amwm" rowspan="2" style="text-align:center"><br>TOTAL<br>LEMBUR</th>
  </tr>
  <tr>
    <td class="tg-amwm" style="text-align:center"><b>MASUK</b></td>
    <td class="tg-amwm" style="text-align:center"><b>KELUAR</b></td>
    <td class="tg-amwm" style="text-align:center"><b>KETERANGAN</b></td>
  </tr>
			<?php 
				$absensidata=mysql_query("SELECT * FROM absensi  where TANGGAL BETWEEN '$startp' AND '$endp' and NIP_PEGAWAI='$objectdata->KODE_PEGAWAI' ORDER BY TANGGAL") or die (mysql_error());
				$no=0;
				while($getabsensidata=mysql_fetch_object($absensidata)){
			
					$datapegawai=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$objectdata->KODE_PEGAWAI'") or die (mysql_error());	
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
					
					$ketentuanjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidata->KODE_JAM_KERJA) or die (mysql_error());
					$tampilketentuanjam=mysql_fetch_object($ketentuanjam);
					
					$ketentuansabtu=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='6'") or die (mysql_error());
					$tampilketentuansabtu=mysql_fetch_object($ketentuansabtu);
					
					
					
					
					
					
					$jammasukkantor=new DateTime($tampilketentuanjam->JAM_DATANG);
					$jammasukpegawai=new DateTime($getabsensidata->JAM_MASUK);
					$terlambat=$jammasukpegawai->diff($jammasukkantor)->format('%h jam %i menit ');
					
				
				?></td>
				<td><?php echo $tampilketentuanjam->JAM_DATANG;?></td>
				<td>
				<?php
				if($datetime->format('D')=="Sat"){
				$jampulangnya=strtotime($tampilketentuanjam->JAM_PULANG)-60*60*$tampilketentuansabtu->VALUE+60*60*1;
				}
				if($datetime->format('D')!="Sat"){
				$jampulangnya=strtotime($tampilketentuanjam->JAM_PULANG);
				}
				$pulang=date('H:i:s',$jampulangnya);
				
				$jamkeluarkantor=new DateTime($pulang);
				$jampulangpegawai=new DateTime($getabsensidata->JAM_KELUAR);
				$pulangcepat=$jampulangpegawai->diff($jamkeluarkantor)->format('%h jam %i menit '); 
				
				echo $pulang;
				?></td>
				<td><?php echo $tampilketentuanjam->KETERANGAN;?></td>
				<td><?php echo $getabsensidata->JAM_MASUK;?></td>
				<td><?php echo $getabsensidata->JAM_KELUAR;?></td>
				<td><?php echo $terlambat;?></td>
				<td><?php echo $pulangcepat;?></td>
				<td><?php 
				
				$queryjam1=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidata->KODE_JAM_KERJA) or die (mysql_error());
				$tampiljam1=mysql_fetch_object($queryjam1);
					
						$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='2'");
						$tmenit=mysql_fetch_object($qmenit);
						$tmenit2=explode(",",$tmenit->VALUE);
						$ckmenit1=date('H:i', strtotime($getabsensidata->JAM_MASUK));
						$ckmenit2=date('H', strtotime($tampiljam1->JAM_DATANG));
						$ckmenit3=$ckmenit2.":".$tmenit2[0];
						
						if($ckmenit1>$ckmenit3){
							$nominal_kehadiran_full=0;
							$jmlterlambat+=1;
							$jammasuknya=$getabsensidata->JAM_MASUK;
						}else{
							$jammasuknya=$tampiljam1->JAM_DATANG;
						}
					
					if($datetime->format('D')=="Sat"){
				
						$jamnya=strtotime($jammasuknya);
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h jam %i menit '); 
					}
					
					if($datetime->format('D')!="Sat"){
						$jamnya=strtotime($jammasuknya)+60*60*1;
						$param1=date('H:i:s',$jamnya);
						$jammasukpegawai=new DateTime($param1);
						$jamkeluarpegawai=new DateTime($getabsensidata->JAM_KELUAR);
						$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h jam %i menit '); 
					}
					$totaljam=$jmlhjam+$totaljam;
					echo $jmlhjam.' ';
				?></td>
				<td><?php
			
					if($datetime->format('D')!="Sat"){
						$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidata->KODE_JAM_KERJA) or die (mysql_error());
						$tampiljam=mysql_fetch_object($queryjam);
						$start=new DateTime($tampiljam->JAM_PULANG);
						$end=new DateTime($getabsensidata->JAM_KELUAR);
			
						if($end < $start){$lembur1 = 0 ;}
						else{$lembur1 = $end->diff($start)->format('%h'); }
					}
			
					if($datetime->format('D')=="Sat"){
			
						if($jmlhjam < $valuesabtu){$lembur1 = 0 ;}
						else{$lembur1 = $jmlhjam-$valuesabtu; }
					}
					$totaljamlembur=$lembur1+$totaljamlembur;
					echo $lembur1.' Jam';
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
			
							if($lembur1 > 0){
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
			
							if($lembur1 > 0){
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
			
							if($lembur1 > 0){
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
				
							if($lembur1 > 0){
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
					
					$lembur=((1/173)*(getthp($NIP) + $uang_makan_transport))*$totaljamlembur;
					$pot_mangkir=((getthp($NIP) + $uang_makan_transport)/26)*$hasil;
				?>
				</td>
			</tr>
		</table>
	
		<br/>
		
	</div>
<?php } ?>

 </div>
</div>