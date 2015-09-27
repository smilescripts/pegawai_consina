<?php
		
	$koneksi=mysql_connect("localhost","root","");
	mysql_select_db("e-pegawai",$koneksi);
	$tanggal=date('Y-m-d H:i:s');
	mysql_query("insert into restore_data values(NULL,'$tanggal','')");
	$nama_file=$_FILES['file']['name'][0];
	$ukuran=$_FILES['file']['size'][0];
	
	include "excel_reader2.php";
// file yang tadinya di upload, di simpan di temporary file PHP, file tersebut yang kita ambil
// dan baca dengan PHP Excel Class
$data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['tmp_name']);
$hasildata = $data->rowcount($sheet_index=0);
// default nilai 
$sukses = 0;
$gagal = 0;
$jmldataklr = 0;
	$jmldatamsk = 0;
	$jmldl = 0;

for ($i=1; $i<=$hasildata; $i++)
	{
		$data1 = $data->val($i,1); 
		$data2 = $data->val($i,2);
		$data3 = $data->val($i,4);
 
		$queryjam=mysql_query("SELECT * FROM jam_kerja WHERE KODE_MASUK='$data3' or KODE_KELUAR='$data3'");
		$tampiljam = mysql_fetch_object($queryjam);
		$tmp=str_replace("/","-",$data2);
		$tmptanggal=date("Y-m-d", strtotime($tmp));
		$tahan=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$data1'");
		$get=mysql_fetch_object($tahan);
		$hasil=$get->NIP_PEGAWAI;
		$TIME=date("H:i:s", strtotime($data2));
		
		$qpeg=mysql_query("select STATUS_PEGAWAI from pegawai where KODE_PEGAWAI='$data1'");
		$tpeg=mysql_fetch_object($qpeg);
		$cekcek=$get->STATUS_PEGAWAI;
		
		if($hasil==""){
			if($cekcek=="Kontrak"){
				$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='15'");
			}
			if($cekcek=="Kontrak Bekasi"){
				$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='16'");
			}
			if($cekcek=="Tetap"){
				$qmenit=mysql_query("select VALUE from pengaturan_penggajian where ID='2'");
			}
			
			$tmenit=mysql_fetch_object($qmenit);
			$ckmenit1=date('i', strtotime($data2));
			$ckmenit2=date('i', strtotime($tmenit->VALUE));
											
			if($ckmenit1<=$ckmenit2){
				$smenit=date('H:i:s', strtotime($tampiljam->JAM_DATANG));
			}else{
				$smenit=date('H:i:s', strtotime($data2));
			}
													
			if($data3==$tampiljam->KODE_MASUK){
				mysql_query("INSERT INTO absensi VALUES(NULL,'1','$data1','$tmptanggal','$smenit','00:00:00','')");
				//header('Content-Type: application/json');
				//echo json_encode(array('cek' => 'true','nip'=>$NIP));
				$jmldatamsk++;
			}
													
			if($data3==$tampiljam->KODE_KELUAR){
				mysql_query("INSERT INTO absensi VALUES(NULL,'1','$data1','$tmptanggal','00:00:00','$TIME','')");
				//header('Content-Type: application/json');
				//echo json_encode(array('cek' => 'true','nip'=>$NIP));
				$jmldataklr++;
			}
		}
													
		if($hasil!=""){
			$tahansemua1=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$data1' and JAM_KELUAR ='00:00:00'");
			$getsemua1=mysql_fetch_object($tahansemua1);
			$hasilgetsemua1=$getsemua1->NIP_PEGAWAI;
												
			$tahansemua2=mysql_query("select NIP_PEGAWAI from absensi where TANGGAL='$tmptanggal' and NIP_PEGAWAI='$data1' and JAM_MASUK ='00:00:00'");
			$getsemua2=mysql_fetch_object($tahansemua2);
			$hasilgetsemua2=$getsemua2->NIP_PEGAWAI;
													
			if($hasilgetsemua1!="" && $data3==$tampiljam->KODE_KELUAR){
				//$jamkeluar=date('H:i:s');
				mysql_query("UPDATE `absensi` SET `JAM_KELUAR` = '$TIME' WHERE `NIP_PEGAWAI` ='$data1' and TANGGAL='$tmptanggal' ");	
				$jmldataklr++;
			}else if($hasilgetsemua2!="" && $data3==$tampiljam->KODE_MASUK){
				//$jamkeluar=date('H:i:s');
				if($cekcek=="Kontrak"){
					$qmenit1=mysql_query("select VALUE from pengaturan_penggajian where ID='15'");
				}
				if($cekcek=="Kontrak Bekasi"){
					$qmenit1=mysql_query("select VALUE from pengaturan_penggajian where ID='16'");
				}
				if($cekcek=="Tetap"){
					$qmenit1=mysql_query("select VALUE from pengaturan_penggajian where ID='2'");
				}
				
				$tmenit1=mysql_fetch_object($qmenit1);
				$ckmenit3=date('i', strtotime($data2));
				$ckmenit4=date('i', strtotime($tmenit1->VALUE));
														
				if($ckmenit3<=$ckmenit4){
					$smenit1=date('H:i:s', strtotime($tampiljam->JAM_DATANG));
				}else{
					$smenit1=date('H:i:s', strtotime($data2));
				}
													
				mysql_query("UPDATE `absensi` SET `JAM_MASUK` = '$smenit1' WHERE `NIP_PEGAWAI` ='$data1' and TANGGAL='$tmptanggal' ");	
				$jmldatamsk++;
			}else{
				$jmldl++;
			}
		}

		if ($hasildata) $sukses++;
		else $gagal++;
	}
echo "<pre>";
echo "<b>import data selesai.</b> <br>";
echo "Data yang berhasil di import : " . $sukses .  "<br>";
echo "Data yang gagal diimport : ".$gagal .  "<br>";

echo "</pre>";
					
								
								}
?>

