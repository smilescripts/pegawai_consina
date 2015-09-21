
<?php
//session_start();
if(!isset($_SESSION['IDPETUGAS'])){
			echo"<script>alert('Lakukan Login Terlebih Dahulu');window.location='index.php'</script>";
		}
include "fungsi/excel_reader2.php";
include_once "koneksi/config.php";
//error_reporting(0);
$module = $_GET['module'];
	
	if ($module == 'pegawai'){
		include "modul/mod_petugas/petugas.php";
	}
	
	elseif ($module == 'import_petugas'){
		include "modul/mod_petugas/import.php";
	}
	
	elseif ($module == 'tambah_petugas'){
		include "modul/mod_petugas/tambah.php";
	}
	
	elseif ($module == 'ubah_petugas'){
		include "modul/mod_petugas/ubah.php";
	}
	
	elseif ($module == 'mahasiswa'){
		include "modul/mod_mahasiswa/mahasiswa.php";
	}
	
	elseif ($module == 'import_mhs'){
		include "modul/mod_mahasiswa/import.php";
	}
	
	elseif ($module == 'tambah_mhs'){
		include "modul/mod_mahasiswa/tambah.php";
	}
	
	elseif ($module == 'ubah_mhs'){
		include "modul/mod_mahasiswa/ubah.php";
	}
	
	elseif ($module == 'beasiswa'){
		include "modul/mod_beasiswa/infobeasiswa.php";
	}
	
	elseif ($module == 'ubah'){
		include "modul/mod_beasiswa/ubah.php";
	}
	
	elseif ($module == 'tambah'){
		include "modul/mod_beasiswa/tambah.php";
	}
	
	elseif ($module == 'view'){
		include "modul/mod_beasiswa/view.php";
	}
	
	elseif ($module == 'laporan'){
		include "modul/mod_laporan/laporan.php";
	}
	
	elseif ($module == 'excel'){
		include "modul/mod_laporan/cetakexcell.php";
	}
	
	elseif ($module == 'backup'){
		include "modul/mod_pengaturan/backupdb.php";
	}
	
	elseif ($module == 'restore'){
		include "modul/mod_pengaturan/restore.php";
	}
	
	elseif ($module == 'penilaian'){
		include "modul/mod_penilaian/penilaian.php";
	}
	
	elseif ($module == 'dpenilaian'){
		include "modul/mod_penilaian/detail_penilaian.php";
	}
	
	elseif ($module == 'hasil'){
		include "modul/mod_penilaian/hasil.php";
	}
	
	elseif ($module == 'persetujuan'){
		include "modul/mod_persetujuan/persetujuan.php";
	}
	
	elseif ($module == 'cek'){
		include "modul/mod_persetujuan/p_persetujuan.php";
	}
	
	elseif ($module == 'disetujui'){
		include "modul/mod_persetujuan/disetujui.php";
	}
	
	elseif ($module == 'aspek'){
		include "modul/mod_aspek/aspekpenilai.php";
	}
	
	elseif ($module == 'tambah_aspek'){
		include "modul/mod_aspek/simpan.php";
	}
	
	elseif ($module == 'ubah_aspek'){
		include "modul/mod_aspek/ubah.php";
	}
	
	elseif ($module == 'lihat_aspek'){
		include "modul/mod_aspek/lihat.php";
	}
	
	elseif ($module == 'hari_libur_outlet'){
		include "modul/mod_hari_libur_outlet/hari_libur_outlet.php";
	}
?>