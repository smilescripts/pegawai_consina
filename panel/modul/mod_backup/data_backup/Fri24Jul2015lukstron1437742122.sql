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

INSERT INTO absensi VALUES("326","1","3","2015-07-27","09:00:00","16:00:00");
INSERT INTO absensi VALUES("325","1","3","2015-07-26","09:00:00","16:00:00");
INSERT INTO absensi VALUES("324","1","3","2015-07-25","10:00:00","18:00:00");
INSERT INTO absensi VALUES("323","1","3","2015-07-24","09:00:00","16:00:00");
INSERT INTO absensi VALUES("322","1","3","2015-07-23","09:00:00","16:00:00");
INSERT INTO absensi VALUES("321","1","3","2015-07-22","09:50:00","16:00:00");
INSERT INTO absensi VALUES("320","1","3","2015-07-21","09:00:00","16:00:00");
INSERT INTO absensi VALUES("319","1","3","2015-07-20","09:00:00","16:00:00");
INSERT INTO absensi VALUES("318","1","3","2015-07-19","09:00:00","16:00:00");
INSERT INTO absensi VALUES("317","1","3","2015-07-18","09:00:00","16:00:00");
INSERT INTO absensi VALUES("316","1","3","2015-07-17","09:00:00","18:00:00");
INSERT INTO absensi VALUES("315","1","3","2015-07-16","09:00:00","16:00:00");
INSERT INTO absensi VALUES("314","1","3","2015-07-15","09:00:00","16:00:00");
INSERT INTO absensi VALUES("313","1","3","2015-07-14","09:00:00","16:00:00");
INSERT INTO absensi VALUES("312","1","3","2015-07-13","09:00:00","16:00:00");
INSERT INTO absensi VALUES("311","1","3","2015-07-12","11:00:00","16:00:00");
INSERT INTO absensi VALUES("310","1","3","2015-07-11","09:00:00","16:00:00");
INSERT INTO absensi VALUES("309","1","3","2015-07-10","09:00:00","16:00:00");
INSERT INTO absensi VALUES("308","1","3","2015-07-09","09:00:00","16:00:00");
INSERT INTO absensi VALUES("307","1","3","2015-07-08","09:00:00","16:00:00");
INSERT INTO absensi VALUES("306","1","3","2015-07-07","09:00:00","16:00:00");
INSERT INTO absensi VALUES("305","1","3","2015-07-06","09:00:00","16:00:00");
INSERT INTO absensi VALUES("304","1","3","2015-07-05","09:00:00","19:00:00");
INSERT INTO absensi VALUES("303","1","3","2015-07-04","09:00:00","17:00:00");
INSERT INTO absensi VALUES("302","1","3","2015-07-03","10:00:00","18:00:00");
INSERT INTO absensi VALUES("301","1","3","2015-07-02","09:30:00","16:00:00");
INSERT INTO absensi VALUES("300","1","3","2015-07-01","09:00:00","16:00:00");
INSERT INTO absensi VALUES("238","1","1","2015-07-30","11:00:00","17:00:00");
INSERT INTO absensi VALUES("237","1","1","2015-07-29","09:00:00","16:00:00");
INSERT INTO absensi VALUES("236","1","1","2015-07-28","09:00:00","16:00:00");
INSERT INTO absensi VALUES("235","1","1","2015-07-27","09:00:00","16:00:00");
INSERT INTO absensi VALUES("234","1","1","2015-07-26","09:00:00","16:00:00");
INSERT INTO absensi VALUES("233","1","1","2015-07-25","10:00:00","18:00:00");
INSERT INTO absensi VALUES("232","1","1","2015-07-24","09:00:00","16:00:00");
INSERT INTO absensi VALUES("231","1","1","2015-07-23","09:00:00","16:00:00");
INSERT INTO absensi VALUES("230","1","1","2015-07-22","09:50:00","16:00:00");
INSERT INTO absensi VALUES("229","1","1","2015-07-21","09:00:00","16:00:00");
INSERT INTO absensi VALUES("228","1","1","2015-07-20","09:00:00","16:00:00");
INSERT INTO absensi VALUES("227","1","1","2015-07-19","09:00:00","16:00:00");
INSERT INTO absensi VALUES("226","1","1","2015-07-18","09:00:00","16:00:00");
INSERT INTO absensi VALUES("225","1","1","2015-07-17","09:00:00","18:00:00");
INSERT INTO absensi VALUES("224","1","1","2015-07-16","09:00:00","16:00:00");
INSERT INTO absensi VALUES("223","1","1","2015-07-15","09:00:00","16:00:00");
INSERT INTO absensi VALUES("222","1","1","2015-07-14","09:00:00","16:00:00");
INSERT INTO absensi VALUES("221","1","1","2015-07-13","09:00:00","16:00:00");
INSERT INTO absensi VALUES("220","1","1","2015-07-12","11:00:00","16:00:00");
INSERT INTO absensi VALUES("219","1","1","2015-07-11","09:00:00","16:00:00");
INSERT INTO absensi VALUES("218","1","1","2015-07-10","09:00:00","16:00:00");
INSERT INTO absensi VALUES("217","1","1","2015-07-09","09:00:00","16:00:00");
INSERT INTO absensi VALUES("216","1","1","2015-07-08","09:00:00","16:00:00");
INSERT INTO absensi VALUES("202","1","2","2015-07-23","09:00:00","16:00:00");
INSERT INTO absensi VALUES("201","1","2","2015-07-22","09:50:00","16:00:00");
INSERT INTO absensi VALUES("200","1","2","2015-07-21","09:00:00","16:00:00");
INSERT INTO absensi VALUES("199","1","2","2015-07-20","09:00:00","16:00:00");
INSERT INTO absensi VALUES("198","1","2","2015-07-19","09:00:00","16:00:00");
INSERT INTO absensi VALUES("197","1","2","2015-07-18","09:00:00","16:00:00");
INSERT INTO absensi VALUES("196","1","2","2015-07-17","09:00:00","18:00:00");
INSERT INTO absensi VALUES("195","1","2","2015-07-16","09:00:00","16:00:00");
INSERT INTO absensi VALUES("194","1","2","2015-07-15","09:00:00","16:00:00");
INSERT INTO absensi VALUES("193","1","2","2015-07-14","09:00:00","16:00:00");
INSERT INTO absensi VALUES("192","1","2","2015-07-13","09:00:00","16:00:00");
INSERT INTO absensi VALUES("191","1","2","2015-07-12","11:00:00","16:00:00");
INSERT INTO absensi VALUES("181","1","2","2015-07-02","09:30:00","16:00:00");
INSERT INTO absensi VALUES("190","1","2","2015-07-11","09:00:00","16:00:00");
INSERT INTO absensi VALUES("189","1","2","2015-07-10","09:00:00","16:00:00");
INSERT INTO absensi VALUES("188","1","2","2015-07-09","09:00:00","16:00:00");
INSERT INTO absensi VALUES("187","1","2","2015-07-08","09:00:00","16:00:00");
INSERT INTO absensi VALUES("186","1","2","2015-07-07","09:00:00","16:00:00");
INSERT INTO absensi VALUES("180","1","2","2015-07-01","09:00:00","16:00:00");
INSERT INTO absensi VALUES("182","1","2","2015-07-03","10:00:00","18:00:00");
INSERT INTO absensi VALUES("185","1","2","2015-07-06","09:00:00","16:00:00");
INSERT INTO absensi VALUES("184","1","2","2015-07-05","09:00:00","19:00:00");
INSERT INTO absensi VALUES("183","1","2","2015-07-04","09:00:00","17:00:00");
INSERT INTO absensi VALUES("215","1","1","2015-07-07","09:00:00","16:00:00");
INSERT INTO absensi VALUES("214","1","1","2015-07-06","09:00:00","16:00:00");
INSERT INTO absensi VALUES("213","1","1","2015-07-05","09:00:00","19:00:00");
INSERT INTO absensi VALUES("212","1","1","2015-07-04","09:00:00","17:00:00");
INSERT INTO absensi VALUES("211","1","1","2015-07-03","10:00:00","18:00:00");
INSERT INTO absensi VALUES("210","1","1","2015-07-02","09:30:00","16:00:00");
INSERT INTO absensi VALUES("299","1","1","2015-07-01","09:00:00","16:00:00");
INSERT INTO absensi VALUES("209","1","2","2015-07-30","11:00:00","17:00:00");
INSERT INTO absensi VALUES("208","1","2","2015-07-29","09:00:00","16:00:00");
INSERT INTO absensi VALUES("207","1","2","2015-07-28","09:00:00","16:00:00");
INSERT INTO absensi VALUES("206","1","2","2015-07-27","09:00:00","16:00:00");
INSERT INTO absensi VALUES("205","1","2","2015-07-26","09:00:00","16:00:00");
INSERT INTO absensi VALUES("204","1","2","2015-07-25","10:00:00","18:00:00");
INSERT INTO absensi VALUES("203","1","2","2015-07-24","09:00:00","16:00:00");
INSERT INTO absensi VALUES("327","1","3","2015-07-28","09:00:00","16:00:00");
INSERT INTO absensi VALUES("328","1","3","2015-07-29","09:00:00","16:00:00");
INSERT INTO absensi VALUES("329","1","3","2015-07-30","11:00:00","17:00:00");
INSERT INTO absensi VALUES("331","1","5","2015-07-07","13:44:59","13:44:59");



DROP TABLE backup_data;

CREATE TABLE `backup_data` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` datetime NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id_backup`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

INSERT INTO backup_data VALUES("35","2015-07-04 12:35:03","Sat04Jul2015lukstron1436006103.sql");
INSERT INTO backup_data VALUES("36","2015-07-04 12:35:05","Sat04Jul2015lukstron1436006105.sql");
INSERT INTO backup_data VALUES("37","2015-07-04 12:35:06","Sat04Jul2015lukstron1436006106.sql");
INSERT INTO backup_data VALUES("38","2015-07-24 14:48:35","Fri24Jul2015lukstron1437742115.sql");
INSERT INTO backup_data VALUES("39","2015-07-24 14:48:39","Fri24Jul2015lukstron1437742119.sql");



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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO cuti VALUES("3","1","cuti hamil2","2015-06-21","2015-06-30","Menunggu","2");



DROP TABLE departemen;

CREATE TABLE `departemen` (
  `KODE_DEPARTEMEN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_DEPARTEMEN` varchar(50) NOT NULL,
  PRIMARY KEY (`KODE_DEPARTEMEN`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

INSERT INTO departemen VALUES("1","HUMAS INTERNAL");
INSERT INTO departemen VALUES("2","KEUANGAN");
INSERT INTO departemen VALUES("3","TEKNOLOGI");
INSERT INTO departemen VALUES("7","MANAGER");
INSERT INTO departemen VALUES("8","GUDANG");



DROP TABLE detail_tunjangan_penggajian;

CREATE TABLE `detail_tunjangan_penggajian` (
  `id_detail_penggajian` int(11) NOT NULL AUTO_INCREMENT,
  `kode_penggajian` varchar(100) NOT NULL,
  `nama_tunjangan` text NOT NULL,
  `nominal_tunjangan` text NOT NULL,
  PRIMARY KEY (`id_detail_penggajian`),
  KEY `kode_penggajian` (`kode_penggajian`),
  CONSTRAINT `detail_tunjangan_penggajian_ibfk_1` FOREIGN KEY (`kode_penggajian`) REFERENCES `head_penggajian` (`kode_penggajian`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=570 DEFAULT CHARSET=latin1;

INSERT INTO detail_tunjangan_penggajian VALUES("558","P07001","anak","300000");
INSERT INTO detail_tunjangan_penggajian VALUES("559","P07001","Istri","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("560","P07001","Keahlian","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("561","P07002","anak","300000");
INSERT INTO detail_tunjangan_penggajian VALUES("562","P07002","Istri","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("563","P07003","anak","300000");
INSERT INTO detail_tunjangan_penggajian VALUES("564","P07003","Istri","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("565","P07003","Keahlian","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("566","P07004","anak","300000");
INSERT INTO detail_tunjangan_penggajian VALUES("567","P07004","Istri","500000");
INSERT INTO detail_tunjangan_penggajian VALUES("568","P07005","anak","300000");
INSERT INTO detail_tunjangan_penggajian VALUES("569","P07005","Istri","500000");



DROP TABLE hari_libur;

CREATE TABLE `hari_libur` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `BULAN` varchar(3) NOT NULL,
  `TAHUN` year(4) NOT NULL,
  `TANGGAL` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO hari_libur VALUES("7","07","2015","2015-07-26,2015-07-27");
INSERT INTO hari_libur VALUES("11","08","2015","2015-08-21,2015-08-22");
INSERT INTO hari_libur VALUES("14","09","2016","2015-09-01,2015-09-02,2015-09-03");



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
  PRIMARY KEY (`kode_penggajian`),
  KEY `kode_pegawai` (`kode_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO head_penggajian VALUES("P07001","2","4000000","300000","261,905","30000","50000","0","463,333","8,161,905","2015-07-24","3","7698571.7619048","300000","83333","0","30","2300000");
INSERT INTO head_penggajian VALUES("P07002","1","4500000","45000000","294,643","30000","150000","0","430,000","50,594,643","2015-07-24","1","50164642.857143","0","250000","0","30","0");
INSERT INTO head_penggajian VALUES("P07003","3","45000000","610000","2,946,429","0","50000","0","50,000","49,856,429","2015-07-24","1","49806428.571429","0","0","0","61","0");
INSERT INTO head_penggajian VALUES("P07004","4","45","74400000","0","0","100000","0","100,000","75,200,045","2015-07-24","1","75100045","0","0","0","62","0");
INSERT INTO head_penggajian VALUES("P07005","5","5000000","76800000","59,524","0","100000","0","100,000","82,659,524","2015-07-24","1","82559523.809524","0","0","0","64","0");



DROP TABLE jabatan;

CREATE TABLE `jabatan` (
  `KODE_JABATAN` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_JABATAN` varchar(50) NOT NULL,
  `TUNJANGAN_JABATAN` int(11) NOT NULL,
  `TUNJANGAN_LAIN` varchar(50) DEFAULT NULL,
  `NOMINAL_TABUNGAN` int(11) NOT NULL,
  `NOMINAL_UMT` int(11) NOT NULL,
  PRIMARY KEY (`KODE_JABATAN`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO jabatan VALUES("12","SPESIALISASI WEBSITE","5000000","2,3,4","50000","10000");
INSERT INTO jabatan VALUES("13","ADMINISTRASI KEUANGAN","1000000","2,3","25000","500000");
INSERT INTO jabatan VALUES("14","FRONT ACCOUNTING","24000000","2,3","15000","400000");
INSERT INTO jabatan VALUES("15","SUPERVISIOR","3500000","2,3","150000","1500000");
INSERT INTO jabatan VALUES("16","GENERAL ACCOUNTING","1450000","2,3","100000","1200000");



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

INSERT INTO kasbon_pegawai VALUES("2","2","2015-07-22","250000","Pinjam","Hutang","1");
INSERT INTO kasbon_pegawai VALUES("3","2","2015-07-22","50000","makan siang","Hutang","2");



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
  PRIMARY KEY (`KODE_MASTER_TUNJANGAN`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO master_tunjangan VALUES("2","anak","300000");
INSERT INTO master_tunjangan VALUES("3","Istri","500000");
INSERT INTO master_tunjangan VALUES("4","Keahlian","500000");



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
  `NIP_PEGAWAI` varchar(25) NOT NULL,
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
  `NO_REKENING` text NOT NULL,
  PRIMARY KEY (`KODE_PEGAWAI`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO pegawai VALUES("1","6311239","Fajar Abby","Bandung","1994-10-01","Islam","Menikah","0","Komplek Margahayu raya","08987898471","15","1","4500000","0000-00-00","0000-00-00","Kontrak","123456.jpg","laki-laki","fajar@gmail.com","1234567");
INSERT INTO pegawai VALUES("2","3311187","Indra Ramadhan","Bandung","1993-03-08","Islam","Belum Kawin","0","Antapani","08678577","12","3","4000000","2015-06-01","0000-00-00","Kontrak","","laki-laki","indra08031993@gmail.com","123432123");
INSERT INTO pegawai VALUES("3","123456789","Fani MA","Bandung","2015-07-04","Islam","Menikah","10","Kiaracondong","08981989111","12","1","45000000","2015-07-04","2015-07-24","Tetap","6311240.jpg","laki-laki","fani@gmail.com","231231142");
INSERT INTO pegawai VALUES("4","6311190","lpkia E","bandung","2015-07-07","Islam","asd","1","asd","213123","16","1","45","2015-07-29","0000-00-00","Tetap","","laki-laki","asd@gmail.com","3213123");
INSERT INTO pegawai VALUES("5","4354353","Lukman","Bandung","2015-07-02","Islam","Kawin","2","sekejati","084325232","16","1","5000000","2015-07-01","0000-00-00","Tetap","4354353.jpg","laki-laki","lukman@gmail.com","321123");



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

INSERT INTO penghargaan VALUES("2","3311187","07","2015","2300000","2015-07-24","Mendapatkan bonus THR");



DROP TABLE petugas;

CREATE TABLE `petugas` (
  `KODE_PETUGAS` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_PETUGAS` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `USERNAME_LOGIN` text NOT NULL,
  `PASSWORD_LOGIN` text NOT NULL,
  PRIMARY KEY (`KODE_PETUGAS`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO petugas VALUES("1","fajar","fajar","fajar","fajar");
INSERT INTO petugas VALUES("2","admin","admin","admin","admin");
INSERT INTO petugas VALUES("3","indra","indra","indra","indra");



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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO pinjaman VALUES("1","2","2015-07-23","1000000","12","ok","Hutang","1","83333","2");
INSERT INTO pinjaman VALUES("2","1","2015-07-23","2500000","10","ok","Hutang","1","250000","-3");



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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO profil_perusahaan VALUES("PT.Indah Jaya Maju","lukstron2015@gmail.com","2147483647","2147483647","Bandung","022-7561278","Jl.Soekarno Hatta no.456","Indonesia","logo.png","1");



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



DROP TABLE tabungan;

CREATE TABLE `tabungan` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NIP` varchar(25) NOT NULL,
  `NOMINAL` int(11) NOT NULL,
  `TANGGAL` date NOT NULL,
  `KODE_PETUGAS` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




