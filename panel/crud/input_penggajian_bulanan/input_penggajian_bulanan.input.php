<?php
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	$startp=$_POST["start"];
	$endp=$_POST["end"];
	
	$tBULAN=new DateTime($endp);
	$tTAHUN=new DateTime($endp);
	
	$BULAN=$tBULAN->format("m");
	$TAHUN=$tTAHUN->format("Y");
	include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji.php");
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Berhasil melakukan proses penggajian karyawan bulanan";
	catat($user,$aksi);
	$Akhir = new DateTime('01-'.$BULAN.'-'.$TAHUN);
	$Akhir->modify('last day of this month');
	$Awal = new DateTime('01-'.$BULAN.'-'.$TAHUN);
	$Awal->modify('first day of this month');
	$tawal=$Awal->format('Y-m-d');
	$takhir=$Akhir->format('Y-m-d');
	$jamsabtu=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='6'") or die (mysql_error());
	$tampiljamsabtu=mysql_fetch_object($jamsabtu);
	$valuesabtu=$tampiljamsabtu->VALUE;
	
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
	}
	
	function hitung_sabtu($tawal,$takhir) {
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
	
	
	$getpegawai=mysql_query("select * from pegawai where STATUS_PEGAWAI='Tetap'");
	
	while($datapegawai=mysql_fetch_object($getpegawai)){
		$NIP=$datapegawai->NIP_PEGAWAI;
		$data=pegawai($NIP);
		$kp=$data->KODE_PEGAWAI;
		$jabatan=jabatan($data->KODE_JABATAN);
		$departemen=departemen($data->KODE_DEPARTEMEN);
	
	
		$KODE_DEPARTEMEN=$datapegawai->KODE_DEPARTEMEN;

		$pinjaman=mysql_query("select SUM(CICILAN_PERBULAN) as CICILAN_PERBULAN  from pinjaman where KODE_PEGAWAI='$kp' and SISA_CICILAN >'0'");
		$getpinjaman=mysql_fetch_object($pinjaman);
		$nominalpinjaman=$getpinjaman->CICILAN_PERBULAN;
		$sisa_cicilan=$getpinjaman->SISA_CICILAN;
		$hutang=gethutang($kp,$BULAN,$TAHUN);	
		$gaji_pokok=$data->GAJI_POKOK;
	
		
		$tabungan=$datapegawai->TABUNGAN;
		$tanggal_gaji=date("Y-m-d");
		$query = "SELECT max(kode_penggajian) as idMaks FROM head_penggajian";
		$hasil = mysql_query($query);
		$data  = mysql_fetch_array($hasil);
		$nim = $data['idMaks'];
		$noUrut = (int) substr($nim, 9, 5);
		$noUrut++;
		$inisial=date('d/m/').'GH-';
		$w = $inisial;
		$IDbaru = $char . sprintf("%05s", $noUrut);
		$getkode=$w.$IDbaru;
		$tipe="SIMPAN";
		$kasbon=$hutang->hutangnya;
/* ------------------Fungsi mangkir-------------------- */
		$kalender=CAL_GREGORIAN;
		$bulan=$BULAN;
		$tahun=$TAHUN;
		$hari=cal_days_in_month($kalender,$bulan,$tahun);
		$bulanini=$BULAN;
		$queryabsensi_data=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'") or die (mysql_error());
		$absen=array();
		
		while($objectdata[]=mysql_fetch_array($queryabsensi_data)){
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
		$tanggalawalcuti=$tanggalcuti->TANGGAL_AWAL;
		$tanggalakhircuti=$tanggalcuti->TANGGAL_AKHIR;

		$tgl1 =$tanggalawalcuti;
		$tgl2 =$tanggalakhircuti;
		$jumlahcuti=selisihHari($tgl1,$tgl2);

		if($jumlahcuti<0){
			$hasiljumlahcuti=0;
		}
		
		if($jumlahcuti>0){
			$hasiljumlahcuti=$jumlahcuti;
		}
	/* -------------------------------------- */
		$uang_makan_transport=$datapegawai->NOMINAL_UMT *$jumlahmasuk ;

		$takehomepay=getthp($NIP) - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN);
		$hitungjumlahharikerja=dateRange($startp,$endp)-selisihHariMinggu($startp,$endp)-$jumlahlibur;
		$mangkir=$hitungjumlahharikerja-$jumlahmasuk-$hasiljumlahcuti;
	
		if($mangkir<0){
			$hasil=0;
		}
	
		if($mangkir>0){
			$hasil=$mangkir;
		}
		else{
			$hasil=0;
		}
	
		
		$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
		$getpenghargaan=mysql_fetch_object($penghargaan);
		$totalpenghargaan=$datapegawai->PENGHARGAAN;
		$terlambat=potogan_terlambat($NIP,$BULAN,$TAHUN);
		$takehomepayfix=getthp($NIP) + $uang_makan_transport+$datapegawai->PENGHARGAAN - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$terlambat);
		
		
		
					$absensidata1=mysql_query("SELECT * FROM absensi  where TANGGAL BETWEEN '$startp' AND '$endp' and NIP_PEGAWAI='$datapegawai->KODE_PEGAWAI'") or die (mysql_error());
					$no=0;
					while($getabsensidata=mysql_fetch_object($absensidata1)){
			
					$datapegawailembur=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$datapegawai->KODE_PEGAWAI'") or die (mysql_error());	
					$pdata=mysql_fetch_object($datapegawailembur);
					$no++;
			
					$datetime = DateTime::createFromFormat('Y-m-d', ''.$getabsensidata->TANGGAL.'');
			
					if($datetime->format('D')=="Mon"){$hari="Senin";}
					if($datetime->format('D')=="Tue"){$hari="Selasa";}
					if($datetime->format('D')=="Wed"){$hari="Rabu";}
					if($datetime->format('D')=="Thu"){$hari="Kamis";}
					if($datetime->format('D')=="Fri"){$hari="Jumat";}
					if($datetime->format('D')=="Sat"){$hari="Sabtu";}
					if($datetime->format('D')=="Sun"){$hari="Minggu";}
					
				
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
			} 
		
		
		
		
		
		$lembur=gajilembur($NIP,$takehomepayfix,$datapegawai->GAJI_POKOK,$totaljamlembur);
		$datalembur=number_format(gajilembur($NIP,$takehomepayfix,$datapegawai->GAJI_POKOK,$totaljamlembur));
		$total_potongan=number_format($hutang->hutangnya+$datapegawai->TABUNGAN+$nominalpinjaman+$terlambat);
		$total_penerimaan=number_format(getthp($NIP) + $uang_makan_transport +$totalpenghargaan+$lembur);
		$pot_mangkir=(($takehomepayfix+$lembur)/26)*$hasil;
		$thp=($takehomepayfix+$lembur)-$pot_mangkir;
		if($tipe=="SIMPAN"){
			$bulanini=$BULAN;
			$cek=mysql_query("select * from head_penggajian where bulan='$bulanini' and tahun='$tahun' and kode_pegawai='$kp'");
			$getcek=mysql_fetch_object($cek);
			
			if($getcek==""){
				mysql_query("insert into head_penggajian values('$getkode','$kp','$gaji_pokok','$uang_makan_transport','$datalembur','$terlambat','$tabungan','$hasil','$total_potongan','$total_penerimaan','$tanggal_gaji','$KODE_DEPARTEMEN','$thp','$kasbon','$nominalpinjaman','$pot_mangkir','$jumlahmasuk','$totalpenghargaan','$hasiljumlahcuti','','Bulanan','$BULAN','$TAHUN','$startp','$endp')");
				$bulansekarang=$BULAN;
				$tahunsekarang=$TAHUN;
				mysql_query("UPDATE `kasbon_pegawai` SET `STATUS` = 'LUNAS' WHERE NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulansekarang' and YEAR(TANGGAL)='$tahunsekarang'");
				
	
				if($tabungan != 0){
					$tgl=date('Y-m-d');	
					mysql_query("insert into tabungan values(NULL,'$kp','$tabungan','$tgl','$_SESSION[KODE_PETUGAS]')");	
		
				}
				
				$pinjamanproses=mysql_query("select KODE_PINJAMAN,SISA_CICILAN,SUM(CICILAN_PERBULAN) as CICILAN_PERBULAN  from pinjaman where KODE_PEGAWAI='$kp' and SISA_CICILAN >'0' group by KODE_PINJAMAN");
				while($getpinjamanproses=mysql_fetch_object($pinjamanproses)){
				$kodepinjaman=$getpinjamanproses->KODE_PINJAMAN;
				$nominalpinjaman1=$getpinjamanproses->CICILAN_PERBULAN;
				$sisa_cicilan1=$getpinjamanproses->SISA_CICILAN;
				
				$tbyragsuran=date('Y-m-d H:i:s');
				$history1 = mysql_fetch_array(mysql_query("SELECT count(ID_PEMBAYARAN) as cicilankeberapa FROM pembayaran_angsuran WHERE ID_PINJAMAN='$kodepinjaman' group by ID_PINJAMAN"));
				$totalbayarcicilan1=$history1["cicilankeberapa"];
				$cicilankenya=$totalbayarcicilan1+1;
				
				mysql_query("UPDATE `pinjaman` SET `SISA_CICILAN` = '$sisa_cicilan1'-1 WHERE KODE_PEGAWAI='$kp' and SISA_CICILAN >'0' and KODE_PINJAMAN='$kodepinjaman'");
				mysql_query("insert into pembayaran_angsuran values(NULL,'$kp','$nominalpinjaman1','$cicilankenya','$tbyragsuran','$_SESSION[KODE_PETUGAS]','$kodepinjaman')");
				mysql_query("delete from pembayaran_angsuran where NOMINAL_PEMBAYARAN='0'");
				}


				$tmptunjanganlain=explode(",",$datapegawai->TUNJANGAN_LAIN);
	
				foreach($tmptunjanganlain as $tmptunjanganlains){
					$pendapatanlain=pendapatan($tmptunjanganlains);
					$nama_tunjangan=$pendapatanlain->NAMA_TUNJANGAN;
					$nominal_tunjangan=$pendapatanlain->NOMINAL;
					mysql_query("insert into detail_tunjangan_penggajian values(NULL,'$getkode','$nama_tunjangan','$nominal_tunjangan')");
				}
			}
		}
	}
	
	if($tipe=="SIMPAN"){
		if($getcek==""){
			header('Content-Type: application/json');
			echo json_encode(array('tipe' => 'SIMPAN'));
		}
	
		if($getcek!=""){
			header('Content-Type: application/json');
			echo json_encode(array('tipe' => 'false'));
		}
	}
	
	if($tipe=="CETAK"){
		$KODE_DEPARTEMEN=$_POST["KODE_DEPARTEMEN"];
		header('Content-Type: application/json');
		
		if($KODE_DEPARTEMEN=="all"){
			echo json_encode(array('tipe' => 'CETAK','departemen'=>"all"));
		}
		
		if($KODE_DEPARTEMEN!="all"){
			echo json_encode(array('tipe' => 'CETAK','departemen'=>$KODE_DEPARTEMEN));
		}
	}
	
	if($tipe=="CETAKSIMPAN"){
		$KODE_DEPARTEMEN=$_POST["KODE_DEPARTEMEN"];
		header('Content-Type: application/json');
	
		if($KODE_DEPARTEMEN=="all"){
			echo json_encode(array('tipe' => 'CETAKSIMPAN','departemen'=>"all"));
		}
	
		if($KODE_DEPARTEMEN!="all"){
			echo json_encode(array('tipe' => 'CETAKSIMPAN','departemen'=>$KODE_DEPARTEMEN));
		}
	}

?>