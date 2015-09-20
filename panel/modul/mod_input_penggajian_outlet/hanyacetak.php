<table id="example" class="table table-bordered" border="1">

    <tr>
		<th width="10%" style="background-color:grey">No</th>
		<th style="background-color:grey">Departemen</th>
		<th width="30%" style="background-color:grey">No Rekening</th>
		<th style="background-color:grey">Nama</th>
		<th style="background-color:grey">Jumlah Transfer</th>
	</tr>
<?php
	session_start();
	$state_session=$_SESSION['STATE_ID'];
	error_reporting(0);
	include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji.php");
	$KODE_DEPARTEMEN=$_GET["dept"];
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
	
	
	
	if($KODE_DEPARTEMEN=="all"){
		$getpegawai=mysql_query("select * from pegawai where STATE_ID='$state_session'");
	}
	
	if($KODE_DEPARTEMEN!="all"){
		$getpegawai=mysql_query("select * from pegawai where  KODE_DEPARTEMEN='$KODE_DEPARTEMEN' and STATE_ID='$state_session'");
	}
	
	while($datapegawai=mysql_fetch_object($getpegawai)){
		$NIP=$datapegawai->NIP_PEGAWAI;
		$data=pegawai($NIP);
		$kp=$data->KODE_PEGAWAI;
		$jabatan=jabatan($data->KODE_JABATAN);
		$departemen=departemen($data->KODE_DEPARTEMEN);
		
		if($KODE_DEPARTEMEN=="all"){
			$KODE_DEPARTEMEN=$datapegawai->KODE_DEPARTEMEN;
		}
		if($KODE_DEPARTEMEN!="all"){
			$KODE_DEPARTEMEN=$datapegawai->KODE_DEPARTEMEN;
		}
		
		$pinjaman=mysql_query("select * from pinjaman where KODE_PEGAWAI='$kp' and SISA_CICILAN!='0'");
		$getpinjaman=mysql_fetch_object($pinjaman);
		$nominalpinjaman=$getpinjaman->CICILAN_PERBULAN;
		$sisa_cicilan=$getpinjaman->SISA_CICILAN;
		$hutang=gethutang($kp);	
		$gaji_pokok=$data->GAJI_POKOK;
	
		$lembur=number_format(nominalumt(gajilembur($NIP)));
	
		$tabungan=$jabatan->NOMINAL_TABUNGAN;
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
		
		while($objectdata[]=mysql_fetch_array($queryabsensi_data)){
		}
		
		$cekdata=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
		$ada=mysql_fetch_object($cekdata);
		$jumlahmasukabsen=mysql_query("SELECT count(TANGGAL) as totmasuk FROM absensi where NIP_PEGAWAI='$kp' and MONTH(TANGGAL)='$bulanini' and YEAR(TANGGAL)='$tahun'");
		$datajumlahmasukabsen=mysql_fetch_object($jumlahmasukabsen);
		$cekada=$ada->TANGGAL;
		
		if($cekada!=""){
			$jumlahmasuk=$datajumlahmasukabsen->totmasuk;
		}
		if($cekada==""){
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
		
		if($datapegawai->STATUS_PEGAWAI=="Tetap"){
			$takehomepay=getthp($NIP) - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN);
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
			
			$pot_mangkir=0;
			$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
			$getpenghargaan=mysql_fetch_object($penghargaan);
			$totalpenghargaan=$datapegawai->PENGHARGAAN;
			$takehomepayfix=getthp($NIP) + $uang_makan_transport+$datapegawai->PENGHARGAAN - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN);
			$total_potongan=number_format($hutang->hutangnya+$datapegawai->TABUNGAN+$nominalpinjaman);
			$terlambat=0;
		}
		
		if($datapegawai->STATUS_PEGAWAI=="Kontrak"){
			$terlambat=potogan_terlambat($NIP);
			$penghargaan=mysql_query("select sum(NOMINAL) as totnom from penghargaan where BULAN='$bulanini' and TAHUN='$tahun' and NIP_PEGAWAI='$NIP'");
			$getpenghargaan=mysql_fetch_object($penghargaan);
			$totalpenghargaan=$datapegawai->PENGHARGAAN;
			$takehomepay=number_format(getthp($NIP) + $uang_makan_transport+$datapegawai->PENGHARGAAN- ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$terlambat));
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
			$takehomepayfix=getthp($NIP) + $uang_makan_transport+ $totalpenghargaan - ($hutang->hutangnya+$nominalpinjaman+$datapegawai->TABUNGAN+$pot_mangkir+$terlambat);
			$total_potongan=number_format(potogan_terlambat($NIP)+$hutang->hutangnya+$datapegawai->TABUNGAN+$nominalpinjaman+$pot_mangkir);
		}
		$total_penerimaan=number_format(getthp($NIP) + $uang_makan_transport+ $totalpenghargaan);
		$no++;
		
		echo'
			<tr>
			<td width="10%">'.$no.'</td>
		';
		
		$penggajiannama=mysql_query("SELECT * FROM departemen where KODE_DEPARTEMEN='$datapegawai->KODE_DEPARTEMEN'") or die (mysql_error());
		$getnamapenggajian=mysql_fetch_object($penggajiannama);
		
		echo'
			<td>'.$getnamapenggajian->NAMA_DEPARTEMEN.'</td>
		';
		
		echo'
			<td width="30%">'.$datapegawai->NO_REKENING.'</td>
			<td>'.$datapegawai->NAMA_PEGAWAI.'</td>
			<td>Rp.'.number_format($takehomepayfix).'</td>
			</tr>
		';
		
	
	
		$no++;
	}
?>
</table>