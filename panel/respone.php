<?php
	include_once "include/koneksi.php";
	include("include/zklib/zklib.php");
	error_reporting(0);
	$getmachine=mysql_query("select * from mesin_absensi");
	$datamachine=mysql_fetch_object($getmachine);
	$ip=$datamachine->IP_ADDRESS;
	$port=$datamachine->PORT_COM;
    $zk = new ZKLib("$ip", $port);
	
    $ret = $zk->connect();
	$attendance = $zk->getAttendance();
					
	$now=date('Y-m-d');
	
	if($zk !=""){

		while(list($idx, $attendancedata) = each($attendance) ) {
							
			$NIP=$attendancedata[1];
			$state=$attendancedata[2];
			$DATE=date("Y-m-d", strtotime($attendancedata[3]));
			$TIME=date("H:i:s", strtotime($attendancedata[3]));
					
			if($NIP!=""){
				$tmp=$TIME;
				$timestamp = strtotime($tmp)/*  + 60*60*2 */;
				$tmpmasuk = date('H:i:s', $timestamp);
					
				$queryjam=mysql_query("SELECT * FROM jam_kerja");
				while($tampiljam = mysql_fetch_object($queryjam)){
					$JAM_DATANG=$tampiljam->JAM_DATANG;
					$JAM_PULANG=$tampiljam->JAM_PULANG;
					
					if($tmpmasuk>=$JAM_DATANG AND $tmpmasuk<=$JAM_PULANG){
						$KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
					}
					if($tmpmasuk>=$JAM_DATANG AND $tmpmasuk>=$JAM_PULANG){
						$KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
					}
				}
					
				$tahan=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$now' and NIP_PEGAWAI='$NIP'");
				$get=mysql_fetch_object($tahan);
				$hasil=$get->NIP_PEGAWAI;
					
				if($hasil=="" && $state==0){
					mysql_query("INSERT INTO absensi 
					VALUES(NULL,'$KODE_JAM_KERJA','$NIP','$DATE','$TIME','00:00:00')");
					
					$zk->clearattendance();	
				}
					
				if($hasil!="" && $state==1){
					$tahansemua1=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$now' and NIP_PEGAWAI='$NIP' and JAM_KELUAR ='00:00:00'");
					$getsemua1=mysql_fetch_object($tahansemua1);
					$hasilgetsemua1=$getsemua1->NIP_PEGAWAI;
					if($hasilgetsemua1!="" ){
						$jamkeluar=date('H:i:s');
						mysql_query("UPDATE `absensi` SET `JAM_KELUAR` = '$jamkeluar' WHERE `NIP_PEGAWAI` ='$NIP' and TANGGAL='$now' ");	
						$zk->clearattendance();		
					}
				}
					
			}
					
		}	
		
		$zk->getTime();
		$zk->enableDevice();
		$zk->disconnect();
	}
?>