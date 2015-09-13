<?php
	include_once "../../include/koneksi.php";
	include_once "../../include/zklib/zklib.php";
	error_reporting(0);
    session_start();
	include "../../include/catat.php";
	$user=$_SESSION['KODE_PETUGAS'];
	$aksi="Melakukan Sinkronisasi Absen Mesin";
	catat($user,$aksi);
	
	$start=$_POST['startall'];
	$end=$_POST['endall'];
	
?>

<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"> Proses Sinkronisasi Absen Mesin</h3>
    </div>
    <div class="panel-body">
		<div class="well">
			<table id="example" class="table table-bordered">
				<thead>
					<tr>
						<th>Nama Mesin</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$getmachine=mysql_query("select * from mesin_absensi");
						while($datamachine=mysql_fetch_object($getmachine)){
						$ip=$datamachine->IP_ADDRESS;
						$port=$datamachine->PORT_COM;
					?>
					<tr>
						<td><?php echo $datamachine->NAMA_MESIN; ?></td>
						<?php
							if(!fsockopen($ip, $port)){
						?>
						<td><b style="color:red;">Disconnected</b></td>
						<?php
							}else{
						?>
						<td id="data-syncA<?php echo $datamachine->KODE_MESIN; ?>" class="data-syncA<?php echo $datamachine->KODE_MESIN; ?>"><b style="color:green;">Connected</b></td>
						<?php
								$zk = new ZKLib($ip, $port);
	
								$ret = $zk->connect();
								$attendance = $zk->getAttendance();
												
								$now=date('Y-m-d');
								$jmldatamsk=0;
								$jmldataklr=0;
								$jmldl=0;
								
								if($zk !=""){
									while(list($idx, $attendancedata) = each($attendance) ) {
										$NIP=$attendancedata[1];
										$state=$attendancedata[2];
										$DATE=$attendancedata[3];
										$TIME=date("H:i:s", strtotime($attendancedata[3]));
										$ckTGL=date("Y-m-d", strtotime($DATE));
										
										if($ckTGL>=$start && $ckTGL<=$end){
											if($NIP!=""){
												$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_MASUK='$state' or KODE_KELUAR='$state'");
												$tampiljam = mysql_fetch_object($queryjam);
												
												if($tampiljam->JAM_DATANG<=$tampiljam->JAM_PULANG){
													$KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
													$tmptanggal=date("Y-m-d", strtotime($DATE));
												}else{
													$KODE_JAM_KERJA = $tampiljam->KODE_JAM_KERJA;
													$ckdate1=date("Y-m-d");
													$ckdate2=date("Y-m-d", strtotime($DATE));
													if($ckdate1>$ckdate2){
														$date1 = str_replace('-', '/', $DATE);
														$tmptanggal = date('Y-m-d',strtotime($date1 . "-1 days"));
													}else{
														$tmptanggal=date("Y-m-d", strtotime($DATE));
													}
												}
													
												$tahan=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$NIP'");
												$get=mysql_fetch_object($tahan);
												$hasil=$get->NIP_PEGAWAI;
													
												if($hasil==""){
													$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='2'");
													$tmenit=mysql_fetch_object($qmenit);
													$ckmenit1=date('i', strtotime($DATE));
													$ckmenit2=date('i', strtotime($tmenit->VALUE));
													
													if($ckmenit1<=$ckmenit2){
														$smenit=date('H:i:s', strtotime($tampiljam->JAM_DATANG));
													}else{
														$smenit=date('H:i:s', strtotime($DATE));
													}
													
													if($state==$tampiljam->KODE_MASUK){
														mysql_query("INSERT INTO absensi VALUES(NULL,'$KODE_JAM_KERJA','$NIP','$tmptanggal','$smenit','00:00:00','')");
														//header('Content-Type: application/json');
														//echo json_encode(array('cek' => 'true','nip'=>$NIP));
														$jmldatamsk++;
													}
													
													if($state==$tampiljam->KODE_KELUAR){
														mysql_query("INSERT INTO absensi VALUES(NULL,'$KODE_JAM_KERJA','$NIP','$tmptanggal','00:00:00','$TIME','')");
														//header('Content-Type: application/json');
														//echo json_encode(array('cek' => 'true','nip'=>$NIP));
														$jmldataklr++;
													}
													
												}
													
												if($hasil!=""){
													$tahansemua1=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$NIP' and JAM_KELUAR ='00:00:00'");
													$getsemua1=mysql_fetch_object($tahansemua1);
													$hasilgetsemua1=$getsemua1->NIP_PEGAWAI;
													
													$tahansemua2=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$NIP' and JAM_MASUK ='00:00:00'");
													$getsemua2=mysql_fetch_object($tahansemua2);
													$hasilgetsemua2=$getsemua2->NIP_PEGAWAI;
													
													if($hasilgetsemua1!="" && $state==$tampiljam->KODE_KELUAR){
														//$jamkeluar=date('H:i:s');
														mysql_query("UPDATE `absensi` SET `JAM_KELUAR` = '$TIME' WHERE `NIP_PEGAWAI` ='$NIP' and TANGGAL='$tmptanggal' ");	
														$jmldataklr++;
													}else if($hasilgetsemua2!="" && $state==$tampiljam->KODE_MASUK){
														//$jamkeluar=date('H:i:s');
														$qmenit1=mysql_query("select VALUE from pengaturan_penggajian where ID='2'");
														$tmenit1=mysql_fetch_object($qmenit1);
														$ckmenit3=date('i', strtotime($DATE));
														$ckmenit4=date('i', strtotime($tmenit1->VALUE));
														
														if($ckmenit3<=$ckmenit4){
															$smenit1=date('H:i:s', strtotime($tampiljam->JAM_DATANG));
														}else{
															$smenit1=date('H:i:s', strtotime($DATE));
														}
													
														mysql_query("UPDATE `absensi` SET `JAM_MASUK` = '$smenit1' WHERE `NIP_PEGAWAI` ='$NIP' and TANGGAL='$tmptanggal' ");	
														$jmldatamsk++;
													}else{
														$jmldl++;
													}
												}
													
											}
										}
												
									}
									//$zk->clearattendance();				
									$zk->getTime();
									$zk->enableDevice();
									$zk->disconnect();
									echo '<script>$(".data-syncA'.$datamachine->KODE_MESIN.'").html("'.$jmldatamsk.'-Sync Masuk And '.$jmldataklr.'-Sync Keluar And '.$jmldl.'-Duplicated").show();</script>';
								}
							}
						?>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
    </div>
</div>
