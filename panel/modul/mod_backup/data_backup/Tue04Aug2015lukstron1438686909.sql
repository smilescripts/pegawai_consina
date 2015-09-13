DROP TABLE absensi;

CREATE TABLE `absensi` (
  `KODE_ABSENSI` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_JAM_KERJA` int(11) NOT NULL,
  `NIP_PEGAWAI` varchar(25) NOT NULL,
  `TANGGAL` date NOT NULL,
  `JAM_MASUK` time DEFAULT NULL,
  `JAM_KELUAR` time DEFAULT NULL,
  PRIMARY KEY (`KODE_ABSENSI`)
) ENGINE=MyISAM AUTO_INCREMENT=332 DEFAULT CHARSET=latin1;




DROP TABLE backup_data;

CREATE TABLE `backup_data` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id_backup`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

INSERT INTO backup_data VALUES("35","2015-07-04 12:35:03","Sat04Jul2015lukstron1436006103.sql");
INSERT INTO backup_data VALUES("36","2015-07-04 12:35:05","Sat04Jul2015lukstron1436006105.sql");
INSERT INTO backup_data VALUES("37","2015-07-04 12:35:06","Sat04Jul2015lukstron1436006106.sql");
INSERT INTO backup_data VALUES("38","2015-07-24 14:48:35","Fri24Jul2015lukstron1437742115.sql");
INSERT INTO backup_data VALUES("39","2015-07-24 14:48:39","Fri24Jul2015lukstron1437742119.sql");
INSERT INTO backup_data VALUES("40","2015-07-24 14:48:42","Fri24Jul2015lukstron1437742122.sql");
INSERT INTO backup_data VALUES("41","2015-08-03 10:00:18","Mon03Aug2015lukstron1438588818.sql");
INSERT INTO backup_data VALUES("42","2015-08-03 10:00:40","Mon03Aug2015lukstron1438588840.sql");



DROP TABLE cuti;

CREATE TABLE `cuti` (
  `KODE_CUTI` int(11) NOT NULL AUTO_INCREMENT,
  `NIP_PEGAWAI` varchar(25) NOT NULL,
  `KETERANGAN` text NOT NULL,
  `TANGGAL_AWAL` date NOT NULL,
  `TANGGAL_AKHIR` date NOT NULL,
  `STATUS` varchar(20) DEFAULT NULL,
  `KODE_PETUGAS` int(11) NOT NULL,
  PRIMARY KEY (`KODE_CUTI`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO cuti VALUES("5","12","Jalan-Jalan","2015-08-03","2015-08-07","Menunggu","1");



DROP TABLE departemen;

CREATE TABLE `departemen` (
  `KODE_DEPARTEMEN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_DEPARTEMEN` varchar(50) NOT NULL,
  `STATE_ID` int(11) NOT NULL,
  PRIMARY KEY (`KODE_DEPARTEMEN`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

INSERT INTO departemen VALUES("15","KEUANGAN","2");
INSERT INTO departemen VALUES("16","PENJUALAN","2");
INSERT INTO departemen VALUES("17","PEMASARAN","2");



DROP TABLE detail_tunjangan_penggajian;

CREATE TABLE `detail_tunjangan_penggajian` (
  `id_detail_penggajian` int(11) NOT NULL AUTO_INCREMENT,
  `kode_penggajian` varchar(100) NOT NULL,
  `nama_tunjangan` text NOT NULL,
  `nominal_tunjangan` text NOT NULL,
  PRIMARY KEY (`id_detail_penggajian`),
  KEY `kode_penggajian` (`kode_penggajian`),
  CONSTRAINT `detail_tunjangan_penggajian_ibfk_1` FOREIGN KEY (`kode_penggajian`) REFERENCES `head_penggajian` (`kode_penggajian`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;




DROP TABLE hari_libur;

CREATE TABLE `hari_libur` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BULAN` varchar(3) NOT NULL,
  `TAHUN` year(4) NOT NULL,
  `TANGGAL` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO hari_libur VALUES("7","07","2015","2015-07-26,2015-07-27");
INSERT INTO hari_libur VALUES("14","09","2016","2015-09-01,2015-09-02,2015-09-03");
INSERT INTO hari_libur VALUES("15","08","2015","2015-08-05");



DROP TABLE head_penggajian;

CREATE TABLE `head_penggajian` (
  `kode_penggajian` varchar(100) NOT NULL,
  `kode_pegawai` int(11) NOT NULL,
  `gaji_pokok` text NOT NULL,
  `uang_makan_transport` text NOT NULL,
  `lembur` text NOT NULL,
  `terlambat` text NOT NULL,
  `tabungan` text NOT NULL,
  `mangkir` text NOT NULL,
  `total_potongan` text NOT NULL,
  `total_penerimaan` text NOT NULL,
  `tanggal_gaji` date NOT NULL,
  `departemen` int(11) NOT NULL,
  `thp` text NOT NULL,
  `kasbon` int(200) NOT NULL,
  `pinjaman` int(100) NOT NULL,
  `potongan_mangkir` int(100) NOT NULL,
  `total_masuk` int(11) NOT NULL,
  `penghargaan` int(100) NOT NULL,
  `jumlah_cuti` int(11) NOT NULL,
  PRIMARY KEY (`kode_penggajian`),
  KEY `kode_pegawai` (`kode_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE jabatan;

CREATE TABLE `jabatan` (
  `KODE_JABATAN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_JABATAN` varchar(50) NOT NULL,
  `TUNJANGAN_JABATAN` int(11) NOT NULL,
  `TUNJANGAN_LAIN` varchar(50) DEFAULT NULL,
  `NOMINAL_TABUNGAN` int(11) NOT NULL,
  `NOMINAL_UMT` int(11) NOT NULL,
  `STATE_ID` int(11) NOT NULL,
  PRIMARY KEY (`KODE_JABATAN`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO jabatan VALUES("18","SUPERVISIOR","4000000","5,6,7","35000","25000","2");



DROP TABLE jam_kerja;

CREATE TABLE `jam_kerja` (
  `KODE_JAM_KERJA` int(11) NOT NULL AUTO_INCREMENT,
  `KETERANGAN` varchar(20) NOT NULL,
  `JAM_DATANG` time NOT NULL,
  `JAM_PULANG` time NOT NULL,
  `KODE_MASUK` int(11) NOT NULL,
  `KODE_KELUAR` int(11) NOT NULL,
  PRIMARY KEY (`KODE_JAM_KERJA`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO jam_kerja VALUES("1","Shif Pagi","09:00:00","16:00:00","0","1");
INSERT INTO jam_kerja VALUES("4","Shif Malam","16:00:00","05:00:00","2","3");



DROP TABLE kasbon_pegawai;

CREATE TABLE `kasbon_pegawai` (
  `KODE_KASBON` int(11) NOT NULL AUTO_INCREMENT,
  `NIP_PEGAWAI` varchar(25) NOT NULL,
  `TANGGAL` date NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `KETERANGAN` varchar(100) NOT NULL,
  `STATUS` varchar(10) NOT NULL,
  `KODE_PETUGAS` int(11) NOT NULL,
  PRIMARY KEY (`KODE_KASBON`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;




DROP TABLE lembur;

CREATE TABLE `lembur` (
  `KODE_LEMBUR` int(11) NOT NULL AUTO_INCREMENT,
  `NIP_PEGAWAI` varchar(25) NOT NULL,
  `BULAN` varchar(20) NOT NULL,
  `TAHUN` year(4) NOT NULL,
  `TANGGAL` int(11) NOT NULL,
  `JUMLAH_JAM_LEMBUR` int(11) NOT NULL,
  PRIMARY KEY (`KODE_LEMBUR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE master_tunjangan;

CREATE TABLE `master_tunjangan` (
  `KODE_MASTER_TUNJANGAN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_TUNJANGAN` varchar(50) NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `STATE_ID` int(11) NOT NULL,
  PRIMARY KEY (`KODE_MASTER_TUNJANGAN`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO master_tunjangan VALUES("5","KEAHLIAN","45000","2");
INSERT INTO master_tunjangan VALUES("6","ANAK","20000","2");
INSERT INTO master_tunjangan VALUES("7","ISTRI","25000","2");



DROP TABLE mesin_absensi;

CREATE TABLE `mesin_absensi` (
  `KODE_MESIN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_MESIN` varchar(50) NOT NULL,
  `IP_ADDRESS` varchar(50) NOT NULL,
  `PORT_COM` varchar(50) NOT NULL,
  PRIMARY KEY (`KODE_MESIN`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO mesin_absensi VALUES("1","Lukstron Machine","192.168.1.201","4370");



DROP TABLE pegawai;

CREATE TABLE `pegawai` (
  `KODE_PEGAWAI` int(11) NOT NULL AUTO_INCREMENT,
  `NIP_PEGAWAI` varchar(25) DEFAULT NULL,
  `NAMA_PEGAWAI` varchar(100) NOT NULL,
  `TEMPAT_LAHIR` varchar(50) DEFAULT NULL,
  `TANGGAL_LAHIR` date DEFAULT NULL,
  `AGAMA` varchar(50) DEFAULT NULL,
  `STATUS_PERNIKAHAN` varchar(50) DEFAULT NULL,
  `JUMLAH_ANAK` int(11) DEFAULT NULL,
  `ALAMAT` text,
  `NOMOR_TELEPON` varchar(20) DEFAULT NULL,
  `KODE_JABATAN` int(11) DEFAULT NULL,
  `KODE_DEPARTEMEN` int(11) DEFAULT NULL,
  `GAJI_POKOK` int(11) DEFAULT NULL,
  `TANGGAL_MASUK` date DEFAULT NULL,
  `TANGGAL_KELUAR` date DEFAULT NULL,
  `STATUS_PEGAWAI` varchar(50) DEFAULT NULL,
  `FOTO_PEGAWAI` text,
  `JENIS_KELAMIN` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `NO_REKENING` text,
  `STATE_ID` int(11) NOT NULL,
  PRIMARY KEY (`KODE_PEGAWAI`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO pegawai VALUES("13","PG2-150800004","Reni Indriani","Jakarta","2015-08-19","Islam","Kawin","1","Jl.Jakarta no 23","123213124231","18","15","4500000","2015-08-04","0000-00-00","Tetap","","Perempuan","demo@gmail.com","21783618726387","2");
INSERT INTO pegawai VALUES("12","PG2-150800003","Mochamad Rendi Yulian","Bandung","2015-08-19","Islam","Kawin","2","Jl.Cimahi raya ","123213124231","18","16","1000000","2015-08-04","0000-00-00","Tetap","","laki-laki","demo@gmail.com","3123123123123","2");
INSERT INTO pegawai VALUES("11","PG2-150800002","Indra Ramadhan","Bandung","2015-08-04","Islam","Kawin","2","Jl.Antapani raya 2","0912038908","18","15","5500000","2015-08-04","0000-00-00","Kontrak","","laki-laki","indra@gmail.com","123432423123","2");
INSERT INTO pegawai VALUES("10","PG2-150800001","Fajar Abby Hydro Prasetyo","Cimahi","1994-01-10","Islam","Belum Kawin","0","Jl.Margahayu raya bandung No.123 Blok C","089508148177","18","15","4500000","2015-08-04","0000-00-00","Tetap","","laki-laki","fajarprasetyo45@gmail.com","123651672357","2");



DROP TABLE pengaturan_penggajian;

CREATE TABLE `pengaturan_penggajian` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PARAMETER` varchar(100) NOT NULL,
  `VALUE` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO pengaturan_penggajian VALUES("1","Jumlah Hari Kerja","6");
INSERT INTO pengaturan_penggajian VALUES("2","Keterlambatan","15,5000");
INSERT INTO pengaturan_penggajian VALUES("3","Lembur","GAJI POKOK");
INSERT INTO pengaturan_penggajian VALUES("4","Tanggal Penggajian","16");
INSERT INTO pengaturan_penggajian VALUES("5","Mangkir","THP");



DROP TABLE penghargaan;

CREATE TABLE `penghargaan` (
  `KODE_PENGHARGAAN` int(11) NOT NULL AUTO_INCREMENT,
  `NIP_PEGAWAI` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `BULAN` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `TAHUN` char(4) COLLATE latin1_general_ci NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `TANGGAL` date NOT NULL,
  `KETERANGAN` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`KODE_PENGHARGAAN`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




DROP TABLE petugas;

CREATE TABLE `petugas` (
  `KODE_PETUGAS` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_PETUGAS` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `USERNAME_LOGIN` text NOT NULL,
  `PASSWORD_LOGIN` text NOT NULL,
  `STATE_ID` int(11) NOT NULL,
  `AKSES` text NOT NULL,
  PRIMARY KEY (`KODE_PETUGAS`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO petugas VALUES("1","fajar Abby","fajar@gmail.com","fajar","fajar","2","42");
INSERT INTO petugas VALUES("2","admin","admin@gmail.com","admin","admin","2","1");
INSERT INTO petugas VALUES("3","indra","indra","indra","indra","0","");
INSERT INTO petugas VALUES("8","Lpkia","lpkia@gmail.com","lpkia","lpkia","2","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22");



DROP TABLE pinjaman;

CREATE TABLE `pinjaman` (
  `KODE_PINJAMAN` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_PEGAWAI` int(11) NOT NULL,
  `TANGGAL` date NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `JUMLAH_BLN` int(11) NOT NULL,
  `KETERANGAN` text,
  `STATUS` varchar(20) DEFAULT NULL,
  `KODE_PETUGAS` int(11) NOT NULL,
  `CICILAN_PERBULAN` int(200) NOT NULL,
  `SISA_CICILAN` int(200) NOT NULL,
  PRIMARY KEY (`KODE_PINJAMAN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE potongan_perusahaan;

CREATE TABLE `potongan_perusahaan` (
  `KODE_POTONGAN_PERUSAHAAN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_POTONGAN_PERUSAHAAN` varchar(50) NOT NULL,
  `PRESENTASE_POTONGAN` int(11) NOT NULL,
  PRIMARY KEY (`KODE_POTONGAN_PERUSAHAAN`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE profil_perusahaan;

CREATE TABLE `profil_perusahaan` (
  `NAMA_PERUSAHAAN` text NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PHONE_1` int(20) NOT NULL,
  `PHONE_2` int(20) NOT NULL,
  `KOTA` varchar(100) NOT NULL,
  `FAXIMILI` varchar(100) NOT NULL,
  `ALAMAT` text NOT NULL,
  `NEGARA` varchar(100) NOT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `STATE_ID` int(11) NOT NULL,
  `COLOR` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO profil_perusahaan VALUES("PT.Indah Jaya Maju","lukstron2015@gmail.com","2147483647","2147483647","Bandung","022-7561278","Jl.Soekarno Hatta no.456","Indonesia","logo.png","1","2","#a6a6a6");



DROP TABLE restore_data;

CREATE TABLE `restore_data` (
  `id_restore` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id_restore`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO restore_data VALUES("1","2015-07-04 12:28:32","");
INSERT INTO restore_data VALUES("2","2015-07-04 12:31:05","");
INSERT INTO restore_data VALUES("3","2015-07-04 12:31:59","");
INSERT INTO restore_data VALUES("4","2015-07-04 12:32:28","");
INSERT INTO restore_data VALUES("5","2015-07-04 12:33:13","");
INSERT INTO restore_data VALUES("6","2015-07-04 12:33:37","");



DROP TABLE rights_control;

CREATE TABLE `rights_control` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GROUP_ID` int(11) NOT NULL,
  `AKSES` text NOT NULL,
  `CONTROL` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

INSERT INTO rights_control VALUES("70","41","1","");
INSERT INTO rights_control VALUES("71","41","2","");
INSERT INTO rights_control VALUES("72","41","3","");
INSERT INTO rights_control VALUES("73","41","4","");
INSERT INTO rights_control VALUES("74","41","5","");
INSERT INTO rights_control VALUES("75","41","6","");
INSERT INTO rights_control VALUES("76","41","7","");
INSERT INTO rights_control VALUES("77","41","8","");
INSERT INTO rights_control VALUES("78","41","9","");



DROP TABLE rights_group;

CREATE TABLE `rights_group` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `GROUP_NAME` text NOT NULL,
  `AKSES` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

INSERT INTO rights_group VALUES("1","Keuangan","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23");
INSERT INTO rights_group VALUES("2","Full Akses","1,2,3,4,5,6,7,8,12,13,15,16,17,18,19,20,21,22,23,24,25");
INSERT INTO rights_group VALUES("41","Manager","2,3,4,5,6,7,8,9");
INSERT INTO rights_group VALUES("42","Admin","1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25");



DROP TABLE rights_menu;

CREATE TABLE `rights_menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MENU_NAME` text NOT NULL,
  `MENU_LINK` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

INSERT INTO rights_menu VALUES("1","State","state");
INSERT INTO rights_menu VALUES("2","Pegawai","pegawai");
INSERT INTO rights_menu VALUES("3","Petugas","petugas");
INSERT INTO rights_menu VALUES("4","Departemen","departemen");
INSERT INTO rights_menu VALUES("5","Jabatan","jabatan");
INSERT INTO rights_menu VALUES("6","Tunjangan","tunjangan");
INSERT INTO rights_menu VALUES("7","Cuti","cuti");
INSERT INTO rights_menu VALUES("8","KasBon","kasbon");
INSERT INTO rights_menu VALUES("9","Pinjaman","pinjaman");
INSERT INTO rights_menu VALUES("10","Jam Kerja","waktu");
INSERT INTO rights_menu VALUES("11","Data Penggajian","penggajian");
INSERT INTO rights_menu VALUES("12","Input Penggajian","input_penggajian");
INSERT INTO rights_menu VALUES("13","Laporan Penggajian","laporan_gaji");
INSERT INTO rights_menu VALUES("14","Absensi Data","absensi_data");
INSERT INTO rights_menu VALUES("15","Penghargaan","penghargaan");
INSERT INTO rights_menu VALUES("16","Cadangkan Basis Data","backup");
INSERT INTO rights_menu VALUES("17","Pulihkan Basis Data","restore");
INSERT INTO rights_menu VALUES("18","Konfigurasi Mesin","mesin");
INSERT INTO rights_menu VALUES("19","Pengaturan Perusahaan","info");
INSERT INTO rights_menu VALUES("20","Monitoring Sistem","monitoring");
INSERT INTO rights_menu VALUES("21","Konfigurasi Penggajian","conf_penggajian");
INSERT INTO rights_menu VALUES("22","Konfigurasi Hari Libur","hari_libur");
INSERT INTO rights_menu VALUES("23","Grup Pengguna","group");
INSERT INTO rights_menu VALUES("24","Pembaruan Sistem","update");
INSERT INTO rights_menu VALUES("25","Cetak Slip Gaji","slip");



DROP TABLE state;

CREATE TABLE `state` (
  `STATE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `STATE_NAME` text NOT NULL,
  PRIMARY KEY (`STATE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO state VALUES("2","Jakarta");
INSERT INTO state VALUES("3","Bandung");
INSERT INTO state VALUES("4","Bogor");
INSERT INTO state VALUES("5","Palembang");
INSERT INTO state VALUES("6","Papua");



DROP TABLE tabungan;

CREATE TABLE `tabungan` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NIP` varchar(25) NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `TANGGAL` date NOT NULL,
  `KODE_PETUGAS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE template;

CREATE TABLE `template` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_PEGAWAI` int(11) NOT NULL,
  `PRIVILEGE` int(11) NOT NULL,
  `PASSWORD` varchar(20) DEFAULT NULL,
  `ENABLED` varchar(10) DEFAULT NULL,
  `FINGERINDEX` int(11) NOT NULL,
  `TMPDATA` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




