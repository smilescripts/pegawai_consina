<?php
	include("koneksi.php");
	
	
	function updategaji($start,$end,$tipe){
		$tBULAN=new DateTime($end);
		$tTAHUN=new DateTime($end);
		
		$BULAN=$tBULAN->format("m");
		$TAHUN=$tTAHUN->format("Y");
		$qheadgaji=mysql_query("select * from head_penggajian where start='$start' and end='$end' and format='$tipe'");
		while($theadgaji=mysql_fetch_object($qheadgaji)){
			if($theadgaji->kasbon>0){
				mysql_query("UPDATE `kasbon_pegawai` SET `STATUS` = 'Hutang' WHERE NIP_PEGAWAI='$theadgaji->kode_pegawai' and MONTH(TANGGAL)='$BULAN' and YEAR(TANGGAL)='$TAHUN'");
			}
			if($theadgaji->pinjaman>0){
				$qpinjamnan=mysql_query("select * from pembayaran_angsuran where NIP_PEGAWAI='$theadgaji->kode_pegawai' and DATE(TANGGAL_PEMBAYARAN)='$theadgaji->tanggal_gaji'");
				while($tpinjaman=mysql_fetch_object($qpinjamnan)){
					$thpinjaman=mysql_fetch_object(mysql_query("select * from pinjaman where KODE_PINJAMAN='$tpinjaman->ID_PINJAMAN'"));
					mysql_query("UPDATE `pinjaman` SET `SISA_CICILAN` = '$thpinjaman->SISA_CICILAN'+1 WHERE KODE_PEGAWAI='$theadgaji->kode_pegawai' and KODE_PINJAMAN='$tpinjaman->ID_PINJAMAN'");
					mysql_query("DELETE from pembayaran_angsuran where ID_PEMBAYARAN='$tpinjaman->ID_PEMBAYARAN'");
				}
			}
			if($theadgaji->tabungan>0){
				mysql_query("DELETE from tabungan where NIP='$theadgaji->kode_pegawai' and TANGGAL='$theadgaji->tanggal_gaji'");
			}
			
			mysql_query("DELETE from head_penggajian where start='$start' and end='$end' and format='$tipe' and kode_pegawai='$theadgaji->kode_pegawai'");
		}
	}
	
	function frmDate($date,$code){
        $explode = explode("-",$date);
        $year  = $explode[0];
        $month = (substr($explode[1],0,1)=="0")?str_replace("0","",$explode[1]):$explode[1];
        $dated = $explode[2];
        $explode_time = explode(" ",$dated);
        $dates = $explode_time[0];
        switch($code){
            // Per Object
            case 4: $format = $dates; break;                                                    
            case 5: $format = $month; break;                                                        
            case 6: $format = $year; break;                
        }        
        return $format; 
	}

	function nmonth($month){
        $thn_kabisat = date("Y") % 4;
        ($thn_kabisat==0)?$feb=29:$feb=28;
        $init_month = array(1=>31,    // Januari
                            2=>$feb,    // Feb
                            3=>31,    // Mar
                            4=>30,    // Apr
                            5=>31,    // Mei
                            6=>30,    // Juni
                            7=>31,    // Juli
                            8=>31,    // Aug
                            9=>30,    // Sep
                            10=>31,    // Oct    
                            11=>30,    // Nov
                            12=>31);// Des
        $nmonth = $init_month[$month];
        return $nmonth;
    }
	
	 function dateRange($start,$end){
        $xdate    =frmDate($start,4);
        $ydate    =frmDate($end,4);
        $xmonth    =frmDate($start,5);
        $ymonth    =frmDate($end,5);
        $xyear    =frmDate($start,6);
        $yyear    =frmDate($end,6);
        // Jika Input tanggal berada ditahun yang sama
        if($xyear==$yyear){
            // Jika Input tanggal berada dibulan yang sama
            if($xmonth==$ymonth){
                $nday=$ydate+1-$xdate;
            } else {
                $r2=NULL;
                $nmonth = $ymonth-$xmonth;            
                $r1 = nmonth($xmonth)-$xdate+1;
                for($i=$xmonth+1;$i<$ymonth;$i++){
                    $r2 = $r2+nmonth($i);
                }
                $r3 = $ydate;
                $nday = $r1+$r2+$r3;
            }
        } else {
            // Jika Input tahun awal berbeda dengan tahun akhir
            $r2=NULL; $r3=NULL;
            $r1=nmonth($xmonth)-$xdate+1;

            for($i=$xmonth+1;$i<13;$i++){
                $r2 = $r2+nmonth($i);
            }
            for($i=1;$i<$ymonth;$i++){
                $r3 = $r3+nmonth($i);
            }
            $r4 = $ydate;
            $nday = $r1+$r2+$r3+$r4;
        }            
        return $nday;
    }


	function selisihHariMinggu($tglAwal, $tglAkhir)
		{
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
			$selisih = dateRange($tglAwal,$tglAkhir);
	
			for($i=1; $i<=$selisih; $i++)
			{
        
				$tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
				$tglstr = date("Y-m-d", $tanggal);
		
		
				if ((date("N", $tanggal) == 1))
				{
					$libur2++;
				}
			}
			return $libur2;
		}
	
	
	function pegawai($NIP){
		
		$querypegawai=mysql_query("select * from pegawai where NIP_PEGAWAI='$NIP'");	
		$getpegawai=mysql_fetch_object($querypegawai);
		return $getpegawai; 	 
	}


	function jabatan($KODE_JABATAN){

		$queryumt=mysql_query("select * from jabatan where KODE_JABATAN='$KODE_JABATAN'");	
		$getumt=mysql_fetch_object($queryumt);

		return $getumt;	
		
	}

	function departemen($KODE_DEPARTEMEN){

		$querydep=mysql_query("select * from departemen where KODE_DEPARTEMEN='$KODE_DEPARTEMEN'");	
		$getdep=mysql_fetch_object($querydep);

		return $getdep;	
		
	}

	function pendapatan($KODE_MASTER_TUNJANGAN){

		$querypen=mysql_query("select * from master_tunjangan where KODE_MASTER_TUNJANGAN='$KODE_MASTER_TUNJANGAN'");	
		$getpen=mysql_fetch_object($querypen);

		return $getpen;	
			
	}

	function nominalumt($NOMINAL_UMT){

		$totalumt=$NOMINAL_UMT;

		return $totalumt;	
		
	}

	function pengaturangaji($ID){

		$querypengaturangaji=mysql_query("select * from pengaturan_penggajian where ID='$ID'");	
		$getpengaturangaji=mysql_fetch_object($querypengaturangaji);

		return $getpengaturangaji;	
		
	}

	function absensi($KODE_PEGAWAI){
		$queryabsensi_data=mysql_query("SELECT * FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI'") or die (mysql_error());
		$getabsensi=mysql_fetch_array($queryabsensi_data);	
			
		return $getabsensi;	
	}

	function gethutang($NIP_PEGAWAI,$BULAN,$TAHUN){
		$bulansekarang=$BULAN;
		$tahunsekarang=$TAHUN;
		$queryhutang=mysql_query("select sum(NOMINAL) as hutangnya from kasbon_pegawai where NIP_PEGAWAI='$NIP_PEGAWAI' and MONTH(TANGGAL)='$bulansekarang'  and YEAR(TANGGAL)='$tahunsekarang' and STATUS!='LUNAS' ");	
		$gethutang=mysql_fetch_object($queryhutang);

		return $gethutang;	
		
	}
	function gethutangrekap($NIP_PEGAWAI,$BULAN,$TAHUN){
		$bulansekarang=$BULAN;
		$tahunsekarang=$TAHUN;
		$queryhutang=mysql_query("select sum(NOMINAL) as hutangnya from kasbon_pegawai where NIP_PEGAWAI='$NIP_PEGAWAI' and MONTH(TANGGAL)='$bulansekarang' and YEAR(TANGGAL)='$tahunsekarang'");	
		$gethutang=mysql_fetch_object($queryhutang);

		return $gethutang;	
		
	}

	function gettelat($NIP){
		$telat2=0;
		$pegawai=pegawai($NIP);
		$pengaturangaji=pengaturangaji(2);
		$waktukerjalembur=waktukerjalembur(1);
		$batastelat2=$waktukerjalembur->JAM_DATANG;
		$bulansekarang=date('m');
		$tahunsekarang=date('Y');
		$queryabsensi_data=mysql_query("SELECT * FROM absensi where JAM_MASUK > '$batastelat2' and NIP_PEGAWAI='$pegawai->KODE_PEGAWAI' and MONTH(TANGGAL)='$bulansekarang' and YEAR(TANGGAL)='$tahunsekarang'") or die (mysql_error());
		
		while($absensi=mysql_fetch_array($queryabsensi_data)){
			$waktukerja=waktukerjalembur($absensi["KODE_JAM_KERJA"]);
			$jamkantormasuk=new DateTime($waktukerja->JAM_DATANG);
			$jammasukpegawai=new DateTime($absensi["JAM_MASUK"]);
			$jammasukpegawai1=$absensi["JAM_MASUK"];
			$batastelat=$pengaturangaji->VALUE;
			$time = $jamkantormasuk->diff($jammasukpegawai);
			$menit=$time->format('%i');
			//if($menit > 15){
				$jam=strtotime($jammasukpegawai1)+60*60*1;
				$param1=date('H:i:s',$jam);
				$param2=New DateTime($param1);
				$param3=$param2->diff($jamkantormasuk);
				$a=$param3->format('%H');
				$telat2=$a+$telat2;
			//}	
		}
			
		return $telat2;
	}


	function getjumlahtelat($NIP){

		$pegawai=pegawai($NIP);
		$waktukerjalembur=waktukerjalembur(1);
		$bulansekarang=date('m');
		$tahunsekarang=date('Y');
		$batastelat=$waktukerjalembur->JAM_DATANG;
		$getjumlahtelat=mysql_query("SELECT count(JAM_MASUK) from absensi where JAM_MASUK > '$batastelat' and MONTH(TANGGAL)='$bulansekarang' and NIP_PEGAWAI='$pegawai->KODE_PEGAWAI' and YEAR(TANGGAL)='$tahunsekarang' ");	
		$hasilget=mysql_fetch_array($getjumlahtelat);
		$data=$hasilget[0];

		return $data;
	}

	function potogan_terlambat($NIP,$BULAN,$TAHUN){

		$pegawai=pegawai($NIP);
		$waktukerjalembur=waktukerjalembur(1);
		$bulansekarang=$BULAN;
		$batastelat=$waktukerjalembur->JAM_DATANG;

		$tahunsekarang=$TAHUN;
		$pengaturangaji=pengaturangaji(2);
		$nominaltelat=$pengaturangaji->VALUE;
		$tmptunjanganlain=array();
		$tmptunjanganlain=explode(",",$nominaltelat);
		$getnominal=$tmptunjanganlain[1];

		$getjumlahtelat=mysql_query("SELECT count(JAM_MASUK) from absensi where JAM_MASUK > '$batastelat' and MONTH(TANGGAL)='$bulansekarang' and NIP_PEGAWAI='$pegawai->KODE_PEGAWAI' and YEAR(TANGGAL)='$tahunsekarang'");	
		$hasilget=mysql_fetch_array($getjumlahtelat);
		$data=$hasilget[0];

		$akumulasi=$data * $getnominal;

		return $akumulasi;
	}
	
	function jmltelat($NIP,$BULAN,$TAHUN){

		$pegawai=pegawai($NIP);
		$waktukerjalembur=waktukerjalembur(1);
		$bulansekarang=$BULAN;
		$batastelat=$waktukerjalembur->JAM_DATANG;

		$tahunsekarang=$TAHUN;
		$pengaturangaji=pengaturangaji(2);
		$nominaltelat=$pengaturangaji->VALUE;
		$tmptunjanganlain=array();
		$tmptunjanganlain=explode(",",$nominaltelat);
		$getnominal=$tmptunjanganlain[1];

		$getjumlahtelat=mysql_query("SELECT count(JAM_MASUK) from absensi where JAM_MASUK > '$batastelat' and MONTH(TANGGAL)='$bulansekarang' and NIP_PEGAWAI='$pegawai->KODE_PEGAWAI' and YEAR(TANGGAL)='$tahunsekarang'");	
		$hasilget=mysql_fetch_array($getjumlahtelat);
		$data=$hasilget[0];

		$akumulasi=$data * $getnominal;

		return $data;
	}

	function jmlembur($NIP){
		$pegawai=pegawai($NIP);
		$ttlembur=0;
		$a=0;
		//$absensi=absensi($pegawai->KODE_PEGAWAI);

		$queryabsensi_data=mysql_query("SELECT * FROM absensi where NIP_PEGAWAI='$pegawai->KODE_PEGAWAI'") or die (mysql_error());
		
		while($absensi=mysql_fetch_array($queryabsensi_data)){
			$waktukerja=waktukerjalembur($absensi["KODE_JAM_KERJA"]);
			$start=new DateTime($waktukerja->JAM_PULANG);
			$end=new DateTime($absensi["JAM_KELUAR"]);
			$lembur = $end->diff($start)->format('%h'); 
			$a=$lembur+$a;
			$ttlembur=$a;
		}
		return $ttlembur;	
	}

	function waktukerjalembur($KODE_JAM_KERJA){

		$querywaktukerja=mysql_query("select * from jam_kerja where KODE_JAM_KERJA='$KODE_JAM_KERJA'");	
		$getwaktukerja=mysql_fetch_object($querywaktukerja);

		return $getwaktukerja;	
		
	}

	function waktukerja($KODE_JAM_KERJA){

		$querywaktukerja=mysql_query("select * from jam_kerja where KODE_JAM_KERJA='$KODE_JAM_KERJA'");	
		$getwaktukerja=mysql_fetch_object($querywaktukerja);
		$start = new DateTime($getwaktukerja->JAM_DATANG);
		$end = new DateTime($getwaktukerja->JAM_PULANG);
		$ttljam=$end->diff($start)->format("%h") != 0 ? $end->diff($start)->format("%h") : 24;
		return $ttljam;	
		
	}

	function gajilembur($NIP,$THP,$GAJI_POKOK,$JMLLEMBUR){

		$tampilpengaturangaji=pengaturangaji(3);
		$rumusperbulan=pengaturangaji(8);
		
		//$harisebulan=pengaturangaji(1);
		//$ttlwaktukerja=waktukerja(1);
		

	
		if($tampilpengaturangaji->VALUE=="THP"){
			$valthp=getthp($NIP);
			$vlembur=((1/$rumusperbulan->VALUE)*$THP)*$JMLLEMBUR;
		}
		if($tampilpengaturangaji->VALUE=="GAJI POKOK"){
			$datapeg=pegawai($NIP);
			$vlembur=((1/$rumusperbulan->VALUE)*$GAJI_POKOK)*$JMLLEMBUR;
		}

		return $vlembur;	
		
	}

	function getthp($NIP){

		$datapeg=pegawai($NIP);	
		$gajipokok=$datapeg->GAJI_POKOK;

		$dataumt=jabatan($datapeg->KODE_JABATAN);
		$umt=$dataumt->NOMINAL_UMT;
		$TUNJANGAN_LAIN=$datapeg->TUNJANGAN_LAIN;

		
		$tmptunjanganlain=array();
		$tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);

		$querytunjangan=mysql_query("select sum(NOMINAL) as tunjangan from master_tunjangan where KODE_MASTER_TUNJANGAN IN($TUNJANGAN_LAIN)");
		$gettunjangan=mysql_fetch_object($querytunjangan);
		$tunjangan=$gettunjangan->tunjangan;

		$thp=$gajipokok+$tunjangan;
			
		return  $thp;
	}
	
	function gettunjangan($NIP){

		$datapeg=pegawai($NIP);	
		$gajipokok=$datapeg->GAJI_POKOK;

		$dataumt=jabatan($datapeg->KODE_JABATAN);
		$umt=$dataumt->NOMINAL_UMT;
		$TUNJANGAN_LAIN=$datapeg->TUNJANGAN_LAIN;

		$gjlembur=gajilembur($NIP);
		$tmptunjanganlain=array();
		$tmptunjanganlain=explode(",",$TUNJANGAN_LAIN);

		$querytunjangan=mysql_query("select sum(NOMINAL) as tunjangan from master_tunjangan where KODE_MASTER_TUNJANGAN IN($TUNJANGAN_LAIN)");
		$gettunjangan=mysql_fetch_object($querytunjangan);
		$tunjangan=$gettunjangan->tunjangan;

		$tunjangannya=$tunjangan;
			
		return  $tunjangannya;
	}
?>