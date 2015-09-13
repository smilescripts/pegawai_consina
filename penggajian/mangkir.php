<?php
	error_reporting(0);
	include("../panel/include/function_hitunggaji.php");
	$kalender=CAL_GREGORIAN;
	$bulan=date('m');
	$tahun=date('Y');
	$hari=cal_days_in_month($kalender,$bulan,$tahun);
	$queryabsensi_data=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='2'") or die (mysql_error());
	$absen=array();
	
	while($objectdata[]=mysql_fetch_array($queryabsensi_data)){
	 
	}
	
	$jumlahmasuk=count($objectdata)-12;

	$tanggallibur = array("01-07-2015","02-07-2015");
	$jumlahlibur=count($tanggallibur);
 
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
			if (date("w",$i) =="0") {
				$minggu++;
			}
		}
		
		return $minggu;
	}
 
	function hitung_sabtu($tawal,$takhir) {
		$adaysec =24*3600;
		$tgl1= strtotime($tawal);
		$tgl2= strtotime($takhir);
		$sabtu=0;
		
		for ($i=$tgl1;$i<$tgl2;$i+=$adaysec){
			if (date("w",$i) =="6") {
				$sabtu++;
			}
		}
		
		return $sabtu;
	}
	
	echo "pada bulan ini terdapat: ".$hari." hari";
	echo "<br/>";

	echo "Tanggal Akhir Bulan Ini :".$Akhir->format('Y-m-d')." <br/>";
	echo "Tanggal Awal Bulan Ini :".$Awal->format('Y-m-d')." <br/>";
	echo "Jumlah Hari minggu:";
	echo hitung_minggu($tawal,$takhir)." Hari"; 
	echo "<br/>Jumlah Hari Sabtu:";
	echo hitung_sabtu($tawal,$takhir)." Hari";
	echo "<br/>Jumlah Hari Libur:";
	echo  $jumlahlibur." Hari<br/>";

	echo "Jumlah Masuk Pegawai: ".$jumlahmasuk." Hari<br/>";
	$hitungjumlahharikerja=$hari-hitung_minggu($tawal,$takhir)-hitung_sabtu($tawal,$takhir)-$jumlahlibur;
	echo "Jumlah Hari Kerja: ".$hitungjumlahharikerja." Hari<br/>";
	$mangkir=$hitungjumlahharikerja-$jumlahmasuk;
	
	if($mangkir<0){
		$hasil=0;
	}
	if($mangkir>0){
		$hasil=$mangkir;
	}else{
		$hasil=0;
	}
	
	echo "Jumlah Mangkir Kerja: ".$hasil." Hari<br/>";


	$bulanini=date('m');
	$libur=mysql_query("select * from hari_libur where BULAN='$bulanini'");
	
	while($viewdata=mysql_fetch_object($libur)){
		$harilibur=array();
		$harilibur=explode(",",$viewdata->TANGGAL);
		foreach($harilibur as $datalibur){
		} 
	
	}
	echo count($harilibur);

?>