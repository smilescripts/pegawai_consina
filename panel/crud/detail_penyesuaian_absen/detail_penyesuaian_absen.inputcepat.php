<?php
	session_start();
	error_reporting(0);
    include_once "../../include/koneksi.php";
	include("../../include/function_hitunggaji_harian.php");
	
	$state_session=$_SESSION['STATE_ID'];
    

	$ID_DETAIL_PENYESUAIAN = $_POST['ID_DETAIL_PENYESUAIAN'];
	$HEAD_ID_PENYESUAIAN = $_POST['HEAD_ID_PENYESUAIAN'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$JML = $_POST['JML'];
	$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
	$KODE_JAM_KERJA = $_POST['KODE_JAM_KERJA'];
	
	$tBULAN=new DateTime($end);
	$tTAHUN=new DateTime($end);
	$BULAN=$tBULAN->format("m");
	$TAHUN=$tTAHUN->format("Y");
	
	$querywaktukerja=mysql_query("select * from jam_kerja where KODE_JAM_KERJA='$KODE_JAM_KERJA'");	
	$getwaktukerja=mysql_fetch_object($querywaktukerja);
	
	if($KODE_JAM_KERJA==1){
		$hariliburmerah=array();
		$liburmerah=mysql_query("select * from hari_libur where BULAN='$BULAN' and TAHUN='$TAHUN'");
		$viewdatamerah=mysql_fetch_object($liburmerah);
		if($viewdatamerah!=""){
			$hariliburmerah=explode(",",$viewdatamerah->TANGGAL);
		}
		
		$jumlahlibur=count($hariliburmerah);
	}else{
		$hariliburmerah=array();
		$liburmerah=mysql_query("select * from hari_libur_outlet where BULAN='$BULAN' and TAHUN='$TAHUN'");
		$viewdatamerah=mysql_fetch_object($liburmerah);
		if($viewdatamerah!=""){
			$hariliburmerah=explode(",",$viewdatamerah->TANGGAL);
		}
		
		$jumlahlibur=count($hariliburmerah);
		
		$cekharilibur=mysql_query("select * from libur_outlet_perbln where BULAN='$BULAN' AND TAHUN='$TAHUN'");
			$getharilibur=mysql_fetch_object($cekharilibur);
			for($liburoutlet=0;$liburoutlet < 4;$liburoutlet++){
				if($liburoutlet==0){
					$tamplibur=$getharilibur->SENIN;
					$parameter=2;
				}
				if($liburoutlet==1){
					$tamplibur=$getharilibur->SELASA;
					$parameter=3;
				}
				if($liburoutlet==2){
					$tamplibur=$getharilibur->RABU;
					$parameter=4;
				}
				if($liburoutlet==3){
					$tamplibur=$getharilibur->KAMIS;
					$parameter=5;
				}
				
				$tmpliburoutlet=array();
				$tmpliburoutlet=explode(",",$tamplibur);
				
				foreach($tmpliburoutlet as $tmpliburoutlets){
					if($tmpliburoutlets==$KODE_PEGAWAI){
						$parameter2=$parameter;
					}
				}		
			}	
			$hari_libur_outlet_outlet=hitunghari($start,$end,$parameter2);
	}
	
	
	
	$cekdata=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI' and TANGGAL BETWEEN '$start' AND '$end' and (JAM_KELUAR!='00:00:00' and JAM_MASUK!='00:00:00')");
	$ada=mysql_fetch_object($cekdata);
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
			if($tanggalawalcuti>=$start and $tanggalakhircuti<=$end){
				$tgl1 =$tanggalawalcuti;
				$tgl2 =$tanggalakhircuti;
				$jalan=1;
			 }else if($tanggalawalcuti<$start and $tanggalakhircuti<=$end){
				$tgl1 =$start;
				$tgl2 =$tanggalakhircuti;
				$jalan=1;
			}else if($tanggalawalcuti>=$start and $tanggalakhircuti>$end){
				$tgl1 =$tanggalawalcuti;
				$tgl2 =$end;
				$jalan=1;
			}else if($tanggalawalcuti<$start and $tanggalakhircuti>$end){
				$tgl1 =$start;
				$tgl2 =$end;
				$jalan=1;
			}else{
				$jalan=0;
			}
			if($jalan==1){
				if($KODE_JAM_KERJA==1){
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
				}else{
					$jumlahcuti1=dateRange($tgl1,$tgl2);
					$hrmingggu=hitunghari($tgl1,$tgl2,$parameter2);
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
	
	if($KODE_JAM_KERJA==1){
		$hitungjumlahharikerja=dateRange($start,$end)-selisihHariMinggu($start,$end)-$jumlahlibur;
	}else{
		$hitungjumlahharikerja=dateRange($start,$end)-$hari_libur_outlet_outlet-$jumlahlibur;
	}
	//$hitungjumlahharikerja=$jumlahlibur;
	$mangkir=$hitungjumlahharikerja-$jumlahmasuk-$hasiljumlahcuti;
	//$mangkir=$hitungjumlahharikerja;
	if($mangkir<=0){
		header('Content-Type: application/json');
		echo json_encode(array('hasil' => '0','ket' => 'nol'));
	}
	
	if($mangkir>0){
		if($mangkir<$JML){
			header('Content-Type: application/json');
			echo json_encode(array('hasil' => $mangkir,'ket' => 'lebih'));
		}else if($mangkir>=$JML){
			$okin=0+$jumlahmasuk+$JML;
			$start1=$start;
			$end1=$end;
			while (strtotime($start1) <= strtotime($end1)) {
				$libur=0;
				$liburcuti1=0;
				$liburminggu=0;
				$getcuti2=mysql_query("select * from cuti where NIP_PEGAWAI='$KODE_PEGAWAI' 
					and (TANGGAL_AWAL BETWEEN '$start1' AND '$end1' or TANGGAL_AKHIR BETWEEN '$start1' AND '$end1')");
				$tanggalcuti2=mysql_fetch_object($getcuti2);
				if($tanggalcuti2->TANGGAL_AWAL!=""){
					$getcuti3=mysql_query("select * from cuti where NIP_PEGAWAI='$KODE_PEGAWAI' 
						and (TANGGAL_AWAL BETWEEN '$start1' AND '$end1' or TANGGAL_AKHIR BETWEEN '$start1' AND '$end1')");
					while($tanggalcuti3=mysql_fetch_object($getcuti3)){
						$tanggalawalcuti1=$tanggalcuti3->TANGGAL_AWAL;
						$tanggalakhircuti1=$tanggalcuti3->TANGGAL_AKHIR;
						if($tanggalawalcuti1>=$start1 and $tanggalakhircuti1<=$end1){
							$tgl3 =$tanggalawalcuti1;
							$tgl4 =$tanggalakhircuti1;
							$jalan1=1;
						 }else if($tanggalawalcuti1<$start1 and $tanggalakhircuti1<=$end1){
							$tgl3 =$start1;
							$tgl4 =$tanggalakhircuti1;
							$jalan1=1;
						}else if($tanggalawalcuti1>=$start1 and $tanggalakhircuti1>$end1){
							$tgl3 =$tanggalawalcuti1;
							$tgl4 =$end1;
							$jalan1=1;
						}else if($tanggalawalcuti1<$start1 and $tanggalakhircuti1>$end1){
							$tgl3 =$start1;
							$tgl4 =$end1;
							$jalan1=1;
						}else{
							$jalan1=0;
						}
						if($jalan1==1){
							$startcuti1 = $tgl3;
							$endcuti1 = $tgl4;
							while (strtotime($startcuti1) <= strtotime($endcuti1)) {
								if($startcuti1==$start1){
									$liburcuti1=1;	
								}
								$startcuti1 = date ("Y-m-d", strtotime("+1 day", strtotime($startcuti1)));
							}
							$jalan1=0;
						}
					}
				}
				
				foreach($hariliburmerah as $datalibur1){
					if($start1==$datalibur1){
						$libur=1;	
					}		
				}
				
				if($KODE_JAM_KERJA==1){
					$hrmingggu2=selisihHariMinggu($start1,$start1);
					if($hrmingggu2!=""){
						$liburminggu=1;
					}else{
						$liburminggu=0;
					}
					
					$hrsabtu=selisihHariSabtu($start1,$start1);
					if($hrsabtu!=""){
						$JAM_MASUK=$getwaktukerja->JAM_DATANG;
						$JAM_KELUAR="13:00:00";
					}else{
						$JAM_MASUK=$getwaktukerja->JAM_DATANG;
						$JAM_KELUAR=$getwaktukerja->JAM_PULANG;
					}
				}else{
					$hrmingggu2=hitunghari($start1,$start1,$parameter2);
					if($hrmingggu2!=""){
						$liburminggu=1;
					}else{
						$liburminggu=0;
					}
					
					$JAM_MASUK=$getwaktukerja->JAM_DATANG;
					$JAM_KELUAR=$getwaktukerja->JAM_PULANG;
				}
				
				if($libur==0 and $liburcuti1==0 and $liburminggu==0){
					$cekdata1=mysql_query("SELECT TANGGAL FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI' and TANGGAL BETWEEN '$start' AND '$end' and (JAM_KELUAR!='00:00:00' and JAM_MASUK!='00:00:00')");
					$ada1=mysql_fetch_object($cekdata1);
					$jumlahmasukabsen1=mysql_query("SELECT count(TANGGAL) as totmasuk FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI' and TANGGAL BETWEEN '$start' AND '$end' and (JAM_KELUAR!='00:00:00' and JAM_MASUK!='00:00:00')");
					$datajumlahmasukabsen1=mysql_fetch_object($jumlahmasukabsen1);
					$cekada1=$ada1->TANGGAL;
					if($cekada1!=""){
						$jumlahmasuk1=$datajumlahmasukabsen1->totmasuk;
					}
					
					if($cekada1==""){
						$jumlahmasuk1=0;
					}
					
					if($jumlahmasuk1<$okin){
						$data56 = mysql_fetch_array(mysql_query("SELECT * FROM absensi where NIP_PEGAWAI='$KODE_PEGAWAI' and TANGGAL='$start1'"));
						if ($data56["KODE_ABSENSI"]=="") {
							mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK','$JAM_KELUAR','$start1','$KODE_PEGAWAI')");
							mysql_query("
								INSERT INTO `absensi` (`KODE_ABSENSI`, `KODE_JAM_KERJA`, `NIP_PEGAWAI`, `TANGGAL`, `JAM_MASUK`, `JAM_KELUAR`, `TELAT`) VALUES (NULL, '$KODE_JAM_KERJA', '$KODE_PEGAWAI', '$start1', '$JAM_MASUK', '$JAM_KELUAR', '0');
							");
						}else if ($data56["KODE_ABSENSI"]!=""){
							if($data56['JAM_MASUK']=='00:00:00' or $data56['JAM_KELUAR']=='00:00:00'){
								mysql_query("insert into detail_penyesuaian_absensi values(NULL,'$HEAD_ID_PENYESUAIAN','$JAM_MASUK','$JAM_KELUAR','$start1','$KODE_PEGAWAI')");
								mysql_query("update absensi set KODE_JAM_KERJA='$KODE_JAM_KERJA',JAM_MASUK='$JAM_MASUK',JAM_KELUAR='$JAM_KELUAR' where TANGGAL='$start1' and NIP_PEGAWAI='$KODE_PEGAWAI' ");
							}
						}
					}
				}
				////------------------------
				$start1 = date ("Y-m-d", strtotime("+1 day", strtotime($start1)));
			}
			
			
			header('Content-Type: application/json');
			echo json_encode(array('ket' => 'ok'));
		}
	}
?>
