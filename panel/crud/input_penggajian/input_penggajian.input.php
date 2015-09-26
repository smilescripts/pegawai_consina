<?php
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	
	$startp=$_POST["start"];
	$endp=$_POST["end"];
	
	$tBULAN=new DateTime($endp);
	$tTAHUN=new DateTime($endp);
	
	$BULAN=$tBULAN->format("m");
	$TAHUN=$tTAHUN->format("Y");
	$tipe="SIMPAN";
	error_reporting(0);
	include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji_harian.php");
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Berhasil melakukan proses penggajian karyawan harian";
	catat($user,$aksi);
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
	
	$tahun=$TAHUN;
	$bulanini=$BULAN;
	$hariliburmerah=array();
	$liburmerah=mysql_query("select * from hari_libur where BULAN='$bulanini' and TAHUN='$tahun'");
	$viewdatamerah=mysql_fetch_object($liburmerah);
	$hariliburmerah=explode(",",$viewdatamerah->TANGGAL);
	
	$getpegawai=mysql_query("select * from pegawai where STATUS_PEGAWAI='Kontrak' and STATE_ID='$_SESSION[STATE_ID]'");
	
	while($datapegawai=mysql_fetch_object($getpegawai)){
				$nominal_pemotongan="";
				$nominal_penambahan="";
				$penyesuaian_pemotongan=mysql_query("select *,SUM(NOMINAL) as total from penyesuaian_dana where KODE_PEGAWAI='$datapegawai->KODE_PEGAWAI' and STATUS='Pemotongan' and BULAN='$bulanini' and TAHUN='$tahun' GROUP BY KODE_PEGAWAI");
				$get_penyesuaian_pemotongan=mysql_fetch_object($penyesuaian_pemotongan);
				$nominal_pemotongan=$get_penyesuaian_pemotongan->total;
				$penyesuaian_penambahan=mysql_query("select *,SUM(NOMINAL) as total from penyesuaian_dana where KODE_PEGAWAI='$datapegawai->KODE_PEGAWAI' and STATUS='Penambahan' and BULAN='$bulanini' and TAHUN='$tahun' GROUP BY KODE_PEGAWAI");
				$get_penyesuaian_penambahan=mysql_fetch_object($penyesuaian_penambahan);
				$nominal_penambahan=$get_penyesuaian_penambahan->total;
				$nominal_pemotongan_tambah=0;
				$nominal_penambahan_tambah=0;
				if($nominal_pemotongan!=""){
					$nominal_pemotongan_tambah=$nominal_pemotongan;
				}
				if($nominal_penambahan!=""){
					
					$nominal_penambahan_tambah=$nominal_penambahan;
			
					
				}
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
		$lembur=number_format(nominalumt(gajilembur($NIP)));
		$tabungan=$nominaltabungan;
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
		
		$kasbon=$hutang->hutangnya;
/* ------------------Fungsi mangkir-------------------- */


		$kalender=CAL_GREGORIAN;
		$bulan=$BULAN;
		$tahun=$TAHUN;
		$haritotal=cal_days_in_month($kalender,$bulan,$tahun);
		$bulanini=$BULAN;
	
	/* ------------------New-------------------- */
		$totalgaji=0;
		$totaljam=0;
		$totaljamlembur=0;
		$totallembur=0;
		$subtotalgaji=0;
		$absensidataharian=mysql_query("SELECT * FROM absensi  where TANGGAL BETWEEN '$startp' AND '$endp' and NIP_PEGAWAI='$kp'") or die (mysql_error());
		$no=0;
		
		while($getabsensidataharian=mysql_fetch_object($absensidataharian)){
			$datapegawaiharian=mysql_query("SELECT * FROM pegawai where KODE_PEGAWAI='$kp'") or die (mysql_error());	
			$pdataharian=mysql_fetch_object($datapegawaiharian);
			$no++;
			$datetimes = DateTime::createFromFormat('Y-m-d', ''.$getabsensidataharian->TANGGAL.'');
			
			if($datetimes->format('D')=="Mon"){$hari="Senin";}
			if($datetimes->format('D')=="Tue"){$hari="Selasa";}
			if($datetimes->format('D')=="Wed"){$hari="Rabu";}
			if($datetimes->format('D')=="Thu"){$hari="Kamis";}
			if($datetimes->format('D')=="Fri"){$hari="Jumat";}
			if($datetimes->format('D')=="Sat"){$hari="Sabtu";}
			if($datetimes->format('D')=="Sun"){$hari="Minggu";}
			
			$queryjam1=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidataharian->KODE_JAM_KERJA) or die (mysql_error());
			$tampiljam1=mysql_fetch_object($queryjam1);
			
			$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='15'");
						$tmenit=mysql_fetch_object($qmenit);
						$tmenit2=explode(",",$tmenit->VALUE);
						$ckmenit1=date('H:i', strtotime($getabsensidataharian->JAM_MASUK));
						$ckmenit2=date('H', strtotime($tampiljam1->JAM_DATANG));
						$ckmenit3=$ckmenit2.":".$tmenit2[0];
						
						if($ckmenit1>$ckmenit3){
							$jammasuknya=$getabsensidataharian->JAM_MASUK;
						}else{
							$jammasuknya=$tampiljam1->JAM_DATANG;
						}
			
			if($datetimes->format('D')=="Sat"){
				
				$jamnya=strtotime($jammasuknya);
				$param1=date('H:i:s',$jamnya);
				$jammasukpegawai=new DateTime($param1);
				$jamkeluarpegawai=new DateTime($getabsensidataharian->JAM_KELUAR);
				$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
			}
			
			if($datetimes->format('D')!="Sat"){
				$jamnya=strtotime($jammasuknya)+60*60*1;
				$param1=date('H:i:s',$jamnya);
				$jammasukpegawai=new DateTime($param1);
				$jamkeluarpegawai=new DateTime($getabsensidataharian->JAM_KELUAR);
				$jmlhjam=$jamkeluarpegawai->diff($jammasukpegawai)->format('%h'); 
			}
			$totaljam=$jmlhjam+$totaljam;
			
			if($datetimes->format('D')!="Sat"){
				$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidataharian->KODE_JAM_KERJA) or die (mysql_error());
				$tampiljam=mysql_fetch_object($queryjam);
				$start=new DateTime($tampiljam->JAM_PULANG);
				$end=new DateTime($getabsensidataharian->JAM_KELUAR);
				
				if($end < $start){$lembur = 0 ;}
				else{$lembur = $end->diff($start)->format('%h'); }
			}
			
			if($datetimes->format('D')=="Sat"){
			
				if($jmlhjam < $valuesabtu){$lembur = 0 ;}
				else{$lembur = $jmlhjam-$valuesabtu; }
			}
			
			$totaljamlembur=$lembur+$totaljamlembur;
			$gajilembur=0;
			
			if($datetimes->format('D')!="Sat"){
				$JAM_PULANG=new DateTime($tampiljam->JAM_PULANG);	
				$jdatang=strtotime($tampiljam->JAM_DATANG)+60*60*1;
				$param3=date('H:i:s',$jdatang);
				$JAM_DATANG=new DateTime($param3);
				$tjam = $JAM_DATANG->diff($JAM_PULANG)->format('%h');
				$hitungharigaji=$datapegawai->GAJI_POKOK/$tjam;
			
				if($jmlhjam > $tjam){
					if($datetimes->format('D')=="Sun"){
						$gajiperhari=$hitungharigaji*$tjam*2;
					}	
			
					if($datetimes->format('D')!="Sun"){
						$gajiperhari=$hitungharigaji*$tjam;
					}
			
					foreach($hariliburmerah as $dataliburnya){
						if($getabsensidataharian->TANGGAL==$dataliburnya){
							$gajiperhari=$hitungharigaji*$tjam*2;	
						}
					} 
					$lemburdata=$jmlhjam-$tjam;
			
					if($lembur > 0){
						if($datetimes->format('D')=="Sun"){
							$gajilembur=$nominallembur*$lemburdata*2;	
						}
						
						if($datetimes->format('D')!="Sun"){
							$gajilembur=$nominallembur*$lemburdata;	
						}
				
						foreach($hariliburmerah as $dataliburnya){
							if($getabsensidataharian->TANGGAL==$dataliburnya){
								$gajilembur=$nominallembur*$lemburdata*2;		
							}
						} 
					}
				}
				else{
					if($datetimes->format('D')=="Sun"){	
						$gajiperhari=$hitungharigaji*$jmlhjam*2;
					}
			
					if($datetimes->format('D')!="Sun"){	
						$gajiperhari=$hitungharigaji*$jmlhjam;
					}
			
					foreach($hariliburmerah as $dataliburnya){
						if($getabsensidataharian->TANGGAL==$dataliburnya){
							$gajiperhari=$hitungharigaji*$tjam*2;	
						}
					} 
					$lemburdata=$jmlhjam-$tjam;
			
					if($lembur > 0){
				
						if($datetimes->format('D')=="Sun"){
							$gajilembur=$nominallembur*$lemburdata*2;	
						}
				
						if($datetimes->format('D')!="Sun"){
							$gajilembur=$nominallembur*$lemburdata;	
						}
				
						foreach($hariliburmerah as $dataliburnya){
							if($getabsensidataharian->TANGGAL==$dataliburnya){
								$gajilembur=$nominallembur*$lemburdata*2;		
							}
						}
					}
				}
			}
			
			if($datetimes->format('D')=="Sat"){
				$hitungharigaji=$datapegawai->GAJI_POKOK/$valuesabtu;
			
				if($jmlhjam > $valuesabtu){
					if($datetimes->format('D')=="Sun"){
						$gajiperhari=$hitungharigaji*$valuesabtu*2;
					}
			
					if($datetimes->format('D')!="Sun"){
						$gajiperhari=$hitungharigaji*$valuesabtu;
					}
					$lemburdata=$jmlhjam-$valuesabtu;
			
					if($lembur > 0){
						if($datetimes->format('D')=="Sun"){
							$gajilembur=$nominallembur*$lemburdata*2;	
						}
				
						if($datetimes->format('D')!="Sun"){
							$gajilembur=$nominallembur*$lemburdata;	
						}
			
					}
				}
				else{
					$gajiperhari=$hitungharigaji*$jmlhjam;
					$lemburdata=$jmlhjam-$valuesabtu;
			
					if($lembur > 0){
						if($datetimes->format('D')=="Sun"){
							$gajilembur=$nominallembur*$lemburdata*2;	
						}
						
						if($datetimes->format('D')!="Sun"){
							$gajilembur=$nominallembur*$lemburdata;	
						}
			
					}
				}	
			}
			$totalgaji=$gajiperhari+$totalgaji;
			$totallembur=$gajilembur+$totallembur;
			$subtotal=$gajiperhari+$gajilembur;
			$subtotalgaji=$subtotal+$subtotalgaji;
		} 
		

	/* ------------------New-------------------- */
	
	
		$queryabsensi_data=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'") or die (mysql_error());
		$absen=array();
	
		while($objectdata=mysql_fetch_array($queryabsensi_data)){
		
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
					foreach($hariliburmerah as $datalibur12){
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
			
			if($jumlahcuti<0){
				$hasiljumlahcuti=0;
			}

			if($jumlahcuti>0){
				$hasiljumlahcuti=$jumlahcuti;
			}
		}else{
			$hasiljumlahcuti=0;
		}
	/* -------------------------------------- */
		
		$uang_makan_transport=$datapegawai->NOMINAL_UMT *$jumlahmasuk ;
		$gaji_pokok=$datapegawai->GAJI_POKOK * $jumlahmasuk;
		$terlambat=potogan_terlambat($NIP);
		$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
		$getpenghargaan=mysql_fetch_object($penghargaan);
		$totalpenghargaan=$datapegawai->PENGHARGAAN;
		$takehomepay=number_format($datapegawai->GAJI_POKOK * $jumlahmasuk +$lembur  + $uang_makan_transport+$datapegawai->PENGHARGAAN- ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$terlambat));
		$hitungjumlahharikerja=dateRange($startp,$endp)-selisihHariMinggu($startp,$endp)-$jumlahlibur;
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
		
		
		//------------------------//
		
		$hariterlambat=0;
		$absensidataharian1=mysql_query("SELECT * FROM absensi  where TANGGAL BETWEEN '$startp' AND '$endp' and NIP_PEGAWAI='$kp'") or die (mysql_error());
		while($getabsensidataharian1=mysql_fetch_object($absensidataharian1)){
			$queryjam2=mysql_query("SELECT * FROM jam_kerja WHERE KODE_JAM_KERJA=".$getabsensidataharian1->KODE_JAM_KERJA) or die (mysql_error());
			$tampiljam2=mysql_fetch_object($queryjam2);
			
			$qmenit2=mysql_query("select VALUE from pengaturan_penggajian where ID='15'");
						$tmenit21=mysql_fetch_object($qmenit2);
						$tmenit22=explode(",",$tmenit21->VALUE);
						$ckmenit12=date('H:i', strtotime($getabsensidataharian1->JAM_MASUK));
						$ckmenit23=date('H', strtotime($tampiljam2->JAM_DATANG));
						$ckmenit33=$ckmenit23.":".$tmenit22[0];
						
						if($ckmenit12>$ckmenit33){
							$nominal_kehadiran_full=0;
							$hariterlambat+=1;
						}
			
		}
	
		$terlambat=potogan_terlambat($NIP);
		$go=str_replace(array(','), array(''), $takehomepay);
		$pot_mangkir=$go / $hitungjumlahharikerja * $hasil;
		$takehomepayfix=getthp($NIP)+($hasiljumlahcuti*$datapegawai->GAJI_POKOK) + $nominal_kehadiran_full+$totalgaji+$totallembur+$uang_makan_transport+$totalpenghargaan+$nominal_penambahan_tambah-($hutang->hutangnya+$nominalpinjaman+$nominaltabungan+$nominal_pemotongan_tambah);
		$total_potongan=number_format($hutang->hutangnya+$nominaltabungan+$nominalpinjaman+$nominal_pemotongan_tambah);
		$total_penerimaan=number_format(getthp($NIP) + $nominal_kehadiran_full+$totalgaji+$totallembur + $uang_makan_transport+ $totalpenghargaan+$nominal_penambahan_tambah);
	
		if($tipe=="SIMPAN"){
			$bulanini=$BULAN;
			$cek=mysql_query("select * from head_penggajian where bulan='$bulanini' and tahun='$tahun' and kode_pegawai='$kp'");
			$getcek=mysql_fetch_object($cek);
			
			if($getcek==""){
				mysql_query("insert into head_penggajian values('$getkode','$kp','$totalgaji','$uang_makan_transport','$totallembur','$hariterlambat','$tabungan','$hasil','$total_potongan','$total_penerimaan','$tanggal_gaji','$KODE_DEPARTEMEN','$takehomepayfix','$kasbon','$nominalpinjaman','0','$jumlahmasuk','$totalpenghargaan','$hasiljumlahcuti','$nominal_kehadiran_full','Harian','$BULAN','$TAHUN','$startp','$endp','$nominal_pemotongan_tambah','$nominal_penambahan_tambah','','','$nominallembur')");
				$bulansekarang=$BULAN;
				$tahunsekarang=$TAHUN;
				mysql_query("UPDATE `kasbon_pegawai` SET `STATUS` = 'LUNAS' WHERE NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulansekarang' and YEAR(TANGGAL)='$tahunsekarang'");
				
				
				if($tabungan !=0){
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
					$nama_tunjangan=$pendapatanlain->KODE_MASTER_TUNJANGAN;
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
