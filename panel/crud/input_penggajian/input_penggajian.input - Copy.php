<?php
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji_harian.php");
	$jamsabtu=mysql_query("SELECT * FROM pengaturan_penggajian WHERE ID='6'") or die (mysql_error());
	$tampiljamsabtu=mysql_fetch_object($jamsabtu);
	$valuesabtu=$tampiljamsabtu->VALUE;
	$Akhir = new DateTime('now');
	$Akhir->modify('last day of this month');
	$Awal = new DateTime('now');
	$Awal->modify('first day of this month');
	$tawal=$Awal->format('Y-m-d');
	$takhir=$Akhir->format('Y-m-d');
	function hitung_minggu($tawal,$takhir) {
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
	}
	
	function selisihHari($tglAwal, $tglAkhir)
	{
	$tglLibur = Array("2015-08-05", "2013-01-05", "2013-01-17");
	$tahun=date('Y');
	$bulanini=date('m');
	$libur1=mysql_query("select * from hari_libur where BULAN='$bulanini' and YEAR(TANGGAL)='$tahun'");
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
	$getpegawai=mysql_query("select * from pegawai where STATUS_PEGAWAI='Kontrak'");
	while($datapegawai=mysql_fetch_object($getpegawai)){
	$NIP=$datapegawai->NIP_PEGAWAI;
	$data=pegawai($NIP);
	$kp=$data->KODE_PEGAWAI;
	$jabatan=jabatan($data->KODE_JABATAN);
	$departemen=departemen($data->KODE_DEPARTEMEN);
	$KODE_DEPARTEMEN=$datapegawai->KODE_DEPARTEMEN;
	$pinjaman=mysql_query("select * from pinjaman where KODE_PEGAWAI='$kp' and SISA_CICILAN!='0'");
	$getpinjaman=mysql_fetch_object($pinjaman);
	$nominalpinjaman=$getpinjaman->CICILAN_PERBULAN;
	$sisa_cicilan=$getpinjaman->SISA_CICILAN;
	$hutang=gethutang($kp);	
	$gaji_pokok=$data->GAJI_POKOK;
	$lembur=number_format(nominalumt(gajilembur($NIP)));
	$tabungan=$datapegawai->TABUNGAN;
	$tanggal_gaji=date("Y-m-d");
	$query = "SELECT max(kode_penggajian) as idMaks FROM head_penggajian";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$nim = $data['idMaks'];
	$noUrut = (int) substr($nim, 3, 3);
	$noUrut++;
	$inisial="P";
	$w = $inisial.date('m');
	$IDbaru = $char . sprintf("%03s", $noUrut);
	$getkode=$w.$IDbaru;
	$tipe=$_POST["tipe"];
	$kasbon=$hutang->hutangnya;
/* ------------------Fungsi mangkir-------------------- */
	$kalender=CAL_GREGORIAN;
	$bulan=date('m');
	$tahun=date('Y');
	$hari=cal_days_in_month($kalender,$bulan,$tahun);
	$bulanini=date('m');
	$queryabsensi_data=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'") or die (mysql_error());
	$absen=array();
	while($objectdata=mysql_fetch_array($queryabsensi_data)){
		
	}
	$cekdata=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
	$ada=mysql_fetch_object($cekdata);

	
	$jumlahmasukabsen=mysql_query("SELECT count(TANGGAL) as totmasuk FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun' and JAM_KELUAR!='00:00:00'");
	$datajumlahmasukabsen=mysql_fetch_object($jumlahmasukabsen);
	$cekada=$ada->TANGGAL;
	
		
	$cekpenyesuaian=mysql_query("SELECT TANGGAL FROM detail_penyesuaian_absensi where KODE_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
	$datacekpenyesuaian=mysql_fetch_object($cekpenyesuaian);
	$jumlahmasukabsenpen=mysql_query("SELECT count(TANGGAL) as totmasukpenyesuaian FROM detail_penyesuaian_absensi where KODE_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
	$datajumlahmasukabsenpenyesiuaian=mysql_fetch_object($jumlahmasukabsenpen);
	$cekadapenyesuian=$datacekpenyesuaian->TANGGAL;
	
	if($cekada!="" && $cekadapenyesuian==""){
	$jumlahmasuk=$datajumlahmasukabsen->totmasuk;
	}
	if($cekada =="" && $cekadapenyesuian!=""){
	$jumlahmasuk=$datajumlahmasukabsenpenyesiuaian->totmasukpenyesuaian;
	}
	
	if($cekada!="" && $cekadapenyesuian!=""){
	$jumlahmasuk=$datajumlahmasukabsen->totmasuk + $datajumlahmasukabsenpenyesiuaian->totmasukpenyesuaian;
	}
	if($cekada==""  && $cekadapenyesuian==""){
	$jumlahmasuk=0;
	}
	
	$tahun=date('Y');
	$bulanini=date('m');
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
	$gaji_pokok=$datapegawai->GAJI_POKOK * $jumlahmasuk;
	$terlambat=potogan_terlambat($NIP);
	$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
	$getpenghargaan=mysql_fetch_object($penghargaan);
	$totalpenghargaan=$datapegawai->PENGHARGAAN;
	$takehomepay=number_format($datapegawai->GAJI_POKOK * $jumlahmasuk +$lembur  + $uang_makan_transport+$datapegawai->PENGHARGAAN- ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$terlambat));
	$hitungjumlahharikerja=$hari-hitung_minggu($tawal,$takhir)/*-hitung_sabtu($tawal,$takhir)*/-$jumlahlibur;
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
	$terlambat=potogan_terlambat($NIP);
	$go=str_replace(array(','), array(''), $takehomepay);
	$pot_mangkir=$go / $hitungjumlahharikerja * $hasil;
	$takehomepayfix=$datapegawai->GAJI_POKOK * $jumlahmasuk +$lembur+ $uang_makan_transport+ $totalpenghargaan - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$pot_mangkir+$terlambat);
	$total_potongan=number_format(potogan_terlambat($NIP)+$hutang->hutangnya+$datapegawai->TABUNGAN+$nominalpinjaman+$pot_mangkir);
	$total_penerimaan=number_format($datapegawai->GAJI_POKOK * $jumlahmasuk + $lembur  + $uang_makan_transport+ $totalpenghargaan);
	if($tipe=="SIMPAN"){
	$bulanini=date('m');
	$cek=mysql_query("select MONTH(tanggal_gaji) from head_penggajian where MONTH(tanggal_gaji)='$bulanini' and YEAR(tanggal_gaji)='$tahun' and kode_pegawai='$kp'");
	$getcek=mysql_fetch_object($cek);
	if($getcek==""){
	mysql_query("insert into head_penggajian values('$getkode','$kp','$gaji_pokok','$uang_makan_transport','$lembur','$terlambat','$tabungan','$hasil','$total_potongan','$total_penerimaan','$tanggal_gaji','$KODE_DEPARTEMEN','$takehomepayfix','$kasbon','$nominalpinjaman','$pot_mangkir','$jumlahmasuk','$totalpenghargaan','$hasiljumlahcuti')");
	mysql_query("UPDATE `pinjaman` SET `SISA_CICILAN` = '$sisa_cicilan'-1 WHERE KODE_PEGAWAI='$kp'");
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
