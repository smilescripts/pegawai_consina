<?php
	session_start();
	include_once "../../include/koneksi.php";
	include("../../include/zklib/zklib.php");
					/* $getmachine=mysql_query("select * from mesin_absensi");
					$datamachine=mysql_fetch_object($getmachine);
					$ip=$datamachine->IP_ADDRESS;
					$port=$datamachine->PORT_COM;
					$zk = new ZKLib("$ip", $port);
					$ret = $zk->connect();  */
					
	//$state_session=$_SESSION['STATE_ID'];			

	if(isset($_POST['hapus'])) {
		mysql_query("DELETE FROM pegawai WHERE KODE_PEGAWAI=".$_POST['hapus']);
	} else {
		$KODE_PEGAWAI = $_POST['KODE_PEGAWAI'];
		$NIP_PEGAWAI = $_POST['NIP_PEGAWAI'];
		$NAMA_PEGAWAI = $_POST['NAMA_PEGAWAI'];
		$TEMPAT_LAHIR = $_POST['TEMPAT_LAHIR'];
		$EMAIL = $_POST['EMAIL'];
		$TANGGAL_LAHIR = $_POST['TANGGAL_LAHIR'];
		$AGAMA = $_POST['AGAMA'];
		$STATUS_PERNIKAHAN = $_POST['STATUS_PERNIKAHAN'];
		$JUMLAH_ANAK=$_POST['JUMLAH_ANAK'];
		$ALAMAT=$_POST['ALAMAT'];
		$NOMOR_TELEPON=$_POST['NOMOR_TELEPON'];
		$KODE_JABATAN=$_POST['KODE_JABATAN'];
		$KODE_DEPARTEMEN=$_POST['KODE_DEPARTEMEN'];
		$GAJI_POKOK=$_POST['GAJI_POKOK'];
		$TANGGAL_MASUK=$_POST['TANGGAL_MASUK'];
		$TANGGAL_KELUAR=$_POST['TANGGAL_KELUAR'];
		$STATUS_PEGAWAI=$_POST['STATUS_PEGAWAI'];
		$JENIS_KELAMIN=$_POST['JENIS_KELAMIN'];
		$NO_REKENING=$_POST['NO_REKENING'];
		$NOMINAL_UMT=$_POST['NOMINAL_UMT'];
		$TABUNGAN=$_POST['TABUNGAN'];
		$PENGHARGAAN=$_POST['PENGHARGAAN'];
		$CATATAN=$_POST['CATATAN'];
		$NOMINAL_LEMBUR=$_POST['NOMINAL_LEMBUR'];
		$OUTLET=$_POST['OUTLET'];
		$STATE_ID=$_POST['STATE_ID'];
		//$FOTO_PEGAWAI=$_POST['FOTO_PEGAWAI'];
		$tmptunjanganlain = $_POST['TUNJANGAN_LAIN'];
		$tmptunjanganlain2=implode(",",$tmptunjanganlain);
		
		$tdepartemen = mysql_fetch_object(mysql_query("SELECT * FROM jabatan where KODE_JABATAN='$KODE_JABATAN'"));
		$KODE_DEPARTEMEN=$tdepartemen->KODE_DEPARTEMEN;
	
		
		if($KODE_PEGAWAI == 0) {
            if($_FILES['FOTO_PEGAWAI']['name'][0]!=""){
				foreach($_FILES['FOTO_PEGAWAI']['name'] as $key => $value){
                    $name = $_FILES['FOTO_PEGAWAI']['name'][$key];
                    $tmp  = $_FILES['FOTO_PEGAWAI']['tmp_name'][$key];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $type=$_FILES['FOTO_PEGAWAI']['type'][$key];
                    $ukuran=$_FILES['FOTO_PEGAWAI']['size'][$key];
                        
                    $new_name = $NIP_PEGAWAI.".".$ext;
                    mysql_query("INSERT INTO pegawai 
					VALUES('','$NIP_PEGAWAI','$NAMA_PEGAWAI','$TEMPAT_LAHIR','$TANGGAL_LAHIR','$AGAMA','$STATUS_PERNIKAHAN','$JUMLAH_ANAK',
				   '$ALAMAT','$NOMOR_TELEPON','$KODE_JABATAN','$KODE_DEPARTEMEN','$GAJI_POKOK','$TANGGAL_MASUK','$TANGGAL_KELUAR',
				   '$STATUS_PEGAWAI','$new_name','$JENIS_KELAMIN','$EMAIL','$NO_REKENING','$STATE_ID','$NOMINAL_UMT','$TABUNGAN','$PENGHARGAAN'
				   ,'$CATATAN','$tmptunjanganlain2','$NOMINAL_LEMBUR','$OUTLET')");
				   $ID_PEGAWAI=mysql_insert_id();
				   include "../../include/catat.php";
					$user=$_SESSION['KODE_PETUGAS'];
					$aksi="Melakukan tambah data Pegawai dengan NIP:".$NIP_PEGAWAI."";
					catat($user,$aksi);
					// $zk->setUser($ID_PEGAWAI,$ID_PEGAWAI, $NAMA_PEGAWAI, '', LEVEL_USER);
					
                    if (!file_exists('../../foto')) {
						mkdir('../../foto');
                    }
			
                    if (!file_exists('../../foto/pegawai/')) {
						mkdir('../../foto/pegawai/');
                    }
				   
                    if(move_uploaded_file($tmp,'../../foto/pegawai/'.$new_name)){
					   
                    }
							
				}
            }else{
				mysql_query("INSERT INTO pegawai 
					VALUES('','$NIP_PEGAWAI','$NAMA_PEGAWAI','$TEMPAT_LAHIR','$TANGGAL_LAHIR','$AGAMA','$STATUS_PERNIKAHAN','$JUMLAH_ANAK',
				   '$ALAMAT','$NOMOR_TELEPON','$KODE_JABATAN','$KODE_DEPARTEMEN','$GAJI_POKOK','$TANGGAL_MASUK','$TANGGAL_KELUAR',
				   '$STATUS_PEGAWAI','','$JENIS_KELAMIN','$EMAIL','$NO_REKENING','$STATE_ID','$NOMINAL_UMT','$TABUNGAN','$PENGHARGAAN','$CATATAN','$tmptunjanganlain2','$NOMINAL_LEMBUR','$OUTLET')");	
					$ID_PEGAWAI=mysql_insert_id();
				   //$zk->setUser($ID_PEGAWAI,$ID_PEGAWAI, $NAMA_PEGAWAI, '', LEVEL_USER);			
				include "../../include/catat.php";
				$user=$_SESSION['KODE_PETUGAS'];
				$aksi="Melakukan tambah data Pegawai dengan NIP:".$NIP_PEGAWAI."";
				catat($user,$aksi);				   
            }
                        
		
		} else {
             if($_FILES['FOTO_PEGAWAI']['name'][0]!=""){
				foreach($_FILES['FOTO_PEGAWAI']['name'] as $key => $value){
                    $name = $_FILES['FOTO_PEGAWAI']['name'][$key];
                    $tmp  = $_FILES['FOTO_PEGAWAI']['tmp_name'][$key];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $type=$_FILES['FOTO_PEGAWAI']['type'][$key];
                    $ukuran=$_FILES['FOTO_PEGAWAI']['size'][$key];
                        
                    $new_name = $NIP_PEGAWAI.".".$ext;
                    mysql_query("UPDATE pegawai SET NIP_PEGAWAI = '$NIP_PEGAWAI',NAMA_PEGAWAI = '$NAMA_PEGAWAI', TEMPAT_LAHIR = '$TEMPAT_LAHIR', TANGGAL_LAHIR = '$TANGGAL_LAHIR'
					, AGAMA = '$AGAMA', JUMLAH_ANAK = '$JUMLAH_ANAK', ALAMAT = '$ALAMAT', NOMOR_TELEPON = '$NOMOR_TELEPON', KODE_JABATAN = '$KODE_JABATAN'
					, KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', GAJI_POKOK = '$GAJI_POKOK', TANGGAL_MASUK = '$TANGGAL_MASUK', TANGGAL_KELUAR = '$TANGGAL_KELUAR'
					, STATUS_PEGAWAI = '$STATUS_PEGAWAI', FOTO_PEGAWAI = '$new_name', JENIS_KELAMIN = '$JENIS_KELAMIN', EMAIL = '$EMAIL', NO_REKENING = '$NO_REKENING', STATE_ID = '$STATE_ID', NOMINAL_UMT = '$NOMINAL_UMT', TABUNGAN = '$TABUNGAN', PENGHARGAAN = '$PENGHARGAAN', CATATAN = '$CATATAN', TUNJANGAN_LAIN = '$tmptunjanganlain2', NOMINAL_LEMBUR = '$NOMINAL_LEMBUR', OUTLET = '$OUTLET' WHERE KODE_PEGAWAI = '$KODE_PEGAWAI' ");
					//$zk->setUser($KODE_PEGAWAI,$KODE_PEGAWAI, $NAMA_PEGAWAI, '', LEVEL_USER);
					include "../../include/catat.php";
					$user=$_SESSION['KODE_PETUGAS'];
					$aksi="Melakukan ubah data Pegawai dengan NIP:".$NIP_PEGAWAI."";
					catat($user,$aksi);
                    
					if (!file_exists('../../foto')) {
						mkdir('../../foto');
                    }
			
                    if (!file_exists('../../foto/pegawai/')) {
						mkdir('../../foto/pegawai/');
                    }
				   
                    if(move_uploaded_file($tmp,'../../foto/pegawai/'.$new_name)){
					   
                    }
							
				}
            }else{
				mysql_query("UPDATE pegawai SET NIP_PEGAWAI = '$NIP_PEGAWAI',NAMA_PEGAWAI = '$NAMA_PEGAWAI', TEMPAT_LAHIR = '$TEMPAT_LAHIR', TANGGAL_LAHIR = '$TANGGAL_LAHIR'
					, AGAMA = '$AGAMA', JUMLAH_ANAK = '$JUMLAH_ANAK', ALAMAT = '$ALAMAT', NOMOR_TELEPON = '$NOMOR_TELEPON', KODE_JABATAN = '$KODE_JABATAN'
					, KODE_DEPARTEMEN = '$KODE_DEPARTEMEN', GAJI_POKOK = '$GAJI_POKOK', TANGGAL_MASUK = '$TANGGAL_MASUK', TANGGAL_KELUAR = '$TANGGAL_KELUAR'
					, STATUS_PEGAWAI = '$STATUS_PEGAWAI', JENIS_KELAMIN = '$JENIS_KELAMIN', EMAIL = '$EMAIL', NO_REKENING = '$NO_REKENING', STATE_ID = '$STATE_ID', NOMINAL_UMT = '$NOMINAL_UMT', TABUNGAN = '$TABUNGAN', PENGHARGAAN = '$PENGHARGAAN', CATATAN = '$CATATAN', TUNJANGAN_LAIN = '$tmptunjanganlain2', NOMINAL_LEMBUR = '$NOMINAL_LEMBUR', OUTLET = '$OUTLET' WHERE KODE_PEGAWAI = '$KODE_PEGAWAI' ");
				include "../../include/catat.php";
				$user=$_SESSION['KODE_PETUGAS'];
				$aksi="Melakukan ubah data Pegawai dengan NIP:".$NIP_PEGAWAI."";
				catat($user,$aksi);
				//$zk->setUser($KODE_PEGAWAI,$KODE_PEGAWAI, $NAMA_PEGAWAI, '', LEVEL_USER);	
            }
		}
	}
?>
