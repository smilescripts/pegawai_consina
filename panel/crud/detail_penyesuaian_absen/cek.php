<?php
    include_once "../../include/koneksi.php";
    include("../../include/function_hitunggaji_harian.php");
	session_start();
	error_reporting(0);
	$state_session=$_SESSION['STATE_ID'];
    
		$ID_DETAIL_PENYESUAIAN = $_GET['ID_DETAIL_PENYESUAIAN'];
		$HEAD_ID_PENYESUAIAN = $_GET['HEAD_ID_PENYESUAIAN'];
		$start = $_GET['start'];
		$end = $_GET['end'];
		$KODE_PEGAWAI = $_GET['KODE_PEGAWAI'];
		$tBULAN=new DateTime($end);
		$tTAHUN=new DateTime($end);
		$BULAN=$tBULAN->format("m");
		$TAHUN=$tTAHUN->format("Y");
	
		$hariliburmerah=array();
		$liburmerah=mysql_query("select * from hari_libur where BULAN='$BULAN' and TAHUN='$TAHUN'");
		$viewdatamerah=mysql_fetch_object($liburmerah);
		$hariliburmerah=explode(",",$viewdatamerah->TANGGAL);
		$jumlahlibur=count($hariliburmerah);
		
		$jumlahmasukabsen=mysql_query("SELECT count(TANGGAL) as totmasuk FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI' and TANGGAL BETWEEN '$start' AND '$end' and (JAM_KELUAR!='00:00:00' and JAM_MASUK!='00:00:00')");
		$datajumlahmasukabsen=mysql_fetch_object($jumlahmasukabsen);
		$cekada=$ada->TANGGAL;
		if($cekada!=""){
			$jumlahmasuk=$datajumlahmasukabsen->totmasuk;
		}
	
		if($cekada==""){
			$jumlahmasuk=0;
		}
		
		$hasiljumlahcuti=0;
		$jumlahcuti=0;
		$jumlahcuti1=0;
		$hrmingggu=0;
			$getcuti=mysql_query("select * from cuti where NIP_PEGAWAI='$KODE_PEGAWAI' 
			and (TANGGAL_AWAL BETWEEN '$start' AND '$end' or TANGGAL_AKHIR BETWEEN '$start' AND '$end')");
			$tanggalcuti=mysql_fetch_object($getcuti);
			if($tanggalcuti->TANGGAL_AWAL!=""){
				$getcuti1=mysql_query("select * from cuti where NIP_PEGAWAI='$KODE_PEGAWAI' 
					and (TANGGAL_AWAL BETWEEN '$start' AND '$end' or TANGGAL_AKHIR BETWEEN '$start' AND '$end')");
				while($tanggalcuti1=mysql_fetch_object($getcuti1)){
					$tanggalawalcuti=$tanggalcuti1->TANGGAL_AWAL;
					$tanggalakhircuti=$tanggalcuti1->TANGGAL_AKHIR;
					if($tanggalawalcuti>=$startp and $tanggalakhircuti<=$endp){
						$tgl1 =$tanggalawalcuti;
						$tgl2 =$tanggalakhircuti;
						$jalan=1;
					 }else if($tanggalawalcuti<$startp and $tanggalakhircuti<=$endp){
						$tgl1 =$startp;
						$tgl2 =$tanggalakhircuti;
						$jalan=1;
					}else if($tanggalawalcuti>=$startp and $tanggalakhircuti>$endp){
						$tgl1 =$tanggalawalcuti;
						$tgl2 =$endp;
						$jalan=1;
					}else if($tanggalawalcuti<$startp and $tanggalakhircuti>$endp){
						$tgl1 =$statp;
						$tgl2 =$endp;
						$jalan=1;
					}else{
						$jalan=0;
					}
					if($jalan==1){
						$jumlahcuti1=dateRange($tgl1,$tgl2);
						$hrmingggu=selisihHariMinggu($tgl1,$tgl2);
						$liburcuti=0;
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
						$jumlahcuti=$jumlahcuti+$jumlahcuti1-$hrmingggu-$liburcuti;
						$jalan=0;
					}
				}
				if($jumlahcuti<=0){
					$hasiljumlahcuti=0;
				}

				if($jumlahcuti>0){
					$hasiljumlahcuti=$jumlahcuti;
				}
			}else{
				$hasiljumlahcuti=0;
			}
			$hitungjumlahharikerja=dateRange($start,$end)-selisihHariMinggu($start,$end)-$jumlahlibur;
			$mangkir=$hitungjumlahharikerja-$jumlahmasuk-$hasiljumlahcuti;
			//$a=dateRange($start,$end);
			if($mangkir<=0){
				/* $header('Content-Type: application/json');
				echo json_encode(array('hasil' => '0')); */
				echo "0";
			}
	
			if($mangkir>0){
				/* $header('Content-Type: application/json');
				echo json_encode(array('hasil' => $a)); */
				echo $mangkir;
			}
		
?>
